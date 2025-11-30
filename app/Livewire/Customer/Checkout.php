<?php

namespace App\Livewire\Customer;

use App\Helpers\CartSession;
use App\Mail\admin\NewOrderNotification;
use App\Mail\user\OrderConfirmation;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Payment;
use App\Models\Product;
use App\Models\ShippingAddress;
use App\Models\ShippingFee;
use App\Models\User;
use App\Services\PaystackService;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Livewire\Component;

class Checkout extends Component
{
    public $cart_items = [];
    public $cart_total = 0;
    public float $discount = 0;
    public float $grand_total = 0;
    public float $totalWeight = 0;
    public string $coupon = '';
    public ?array $appliedCoupon = null;
    public array $states = [];
    public ?int $selectedCountry = null;
    public ?string $selectedState = null;
    public string $address = '';
    public string $city = '';
    public string $phone_number = '';
    public float $shippingFee = 0;
    public $state_id;
    public string $zipCode = '';
    public $coupon_id;
    public $paymentMethod;



    public function mount()
    {
        $this->loadData();
    }
    protected function loadData()
    {
        $this->cart_items = CartSession::getCartItemsFromSession();
        $this->cart_total = CartSession::calculateGrandTotal($this->cart_items);
        $this->totalWeight = array_sum(array_column($this->cart_items, 'weight'));
    }

    public function updatedSelectedCountry($value)
    {
        $this->states = ShippingFee::where('country_id', $value)->pluck('state')->unique()->toArray();
        $this->selectedState = null;
        $this->shippingFee = 0;
    }

    public function updatedSelectedState($value)
    {
        $this->updateTotal();
    }

    public function applyCoupon()
    {
        $this->validate([
            'coupon' => 'required|max:30'
        ]);

        $res = $this->checkCoupon();
        if ($res) {
            $this->updateTotal();
            $this->dispatch('alert-modal', [
                'message' => 'Added sucessfully',
                'type' => 'success',
                'product' => 'Coupon',
            ]);
        } else {
            $this->dispatch('alert-modal', [
                'message' => 'invalid or expired.',
                'type' => 'error',
                'product' => 'Coupon Error',
            ]);
        }
    }

    protected function checkCoupon()
    {
        $coupon = Coupon::where('code', $this->coupon)
            ->whereDate('end_date', '>=', now())
            ->whereDate('start_date', '<=', now())
            ->first();

        if (!$coupon) {
            $this->coupon_id = null;
            $this->discount = 0;
            return false;
        } else {
            $this->coupon_id = $coupon->id;
            $this->discount = $this->cart_total * ($coupon->discount_percentage / 100);
            return true;
        }
    }


    protected function  updateTotal()
    {
        $this->loadData();
        $this->checkCoupon();
        $shipping = ShippingFee::where('country_id', $this->selectedCountry)
            ->where('state', $this->selectedState)
            ->first();
        if ($shipping) {
            $this->state_id = $shipping->id;
            $this->shippingFee = $shipping->base_fee + ($shipping->fee_per_kg * round($this->totalWeight));
            $this->grand_total = round(max(0, $this->cart_total + $this->shippingFee - $this->discount));
        } else {
            $this->shippingFee = 0;
            $this->grand_total = round(max(0, $this->cart_total + $this->shippingFee - $this->discount));
        }
    }
    protected function getRandomLetters($length = 2)
    {
        return substr(str_shuffle(str_repeat('abcdefghijklmnopqrstuvwxyz', $length)), 0, $length);
    }

    public function checkout()
    {
        $this->updateTotal();
        if (count($this->cart_items) < 1) {
            $this->dispatch('alert-modal', [
                'message' => 'Please add items to cart.',
                'type' => 'error',
                'product' => 'Cart Empty',
            ]);
            return;
        }
        if ($this->grand_total <= 0) {
            $this->dispatch('alert-modal', [
                'message' => 'Please add items to cart.',
                'type' => 'error',
                'product' => 'Cart Empty',
            ]);
            return;
        }
        $pendingPayment = Payment::where('user_id', Auth::user()->id)
            ->where('status', 'pending')
            ->where('created_at', '>=', Carbon::now()->subMinutes(30))
            ->exists();  // You can use exists() to check for the presence of such a payment

        if ($pendingPayment) {
            $this->dispatch('alert-modal', [
                'message' => 'Please complete or cancel it before creating a new order.',
                'type' => 'error',
                'product' => 'Pending Payment',
            ]);
            return;
        }
        $this->validate([
            'address' => 'required|string|max:255',
            'city' => 'required|string|max:40',
            'phone_number' => 'required|string|max:20',
            'zipCode' => 'required|string|max:30',
            'selectedCountry' => 'required|integer|exists:countries,id',
            'selectedState' => 'required|max:50',
            'paymentMethod' => 'required|in:transfer,card,crypto',
            'coupon' => 'nullable|string|max:50',
        ], [
            'phone_number.required' => 'Phone number is required.',
            'phone_number.string' => 'Phone number not valid.',
            'phone_number.max' => 'Phone number not valid.',

            'zipCode.required' => 'Post code is required.',
            'zipCode.string' => 'Post code not valid.',
            'zipCode.max' => 'Post code not valid.',

            'selectedCountry.required' => 'Please select a country.',
            'selectedCountry.integer' => 'Country not valid.',
            'selectedCountry.exists' => 'Country not valid.',

            'selectedState.required' => 'Please select a state.',
            'selectedState.max' => 'State  not valid.',
            'selectedState.exists' => 'State not valid.',

            'paymentMethod.required' => 'Please select a payment method.',
            'paymentMethod.in' => 'Payment method is not supported.',
        ]);
        $strg = $this->getRandomLetters();
        try {
            // Start the transaction
            DB::beginTransaction();

            // Create Shipping Address
            $shippingAddress = ShippingAddress::create([
                'user_id' => Auth::user()->id,
                'country_id' => $this->selectedCountry,
                'shipping_fee_id' => $this->state_id,
                'city' => $this->city,
                'address' => $this->address,
                'phone_number' => $this->phone_number,
                'zip_code' => $this->zipCode
            ]);

            // Create Order
            $order = Order::create([
                'reference' => 'ord-' . $strg . date('dHis'),
                'user_id' => Auth::user()->id,
                'shipping_address_id' => $shippingAddress->id,
                'total_price' => $this->grand_total,
                'note' => $this->note ?? null,
                'phone_number' => $this->phone_number,
                'coupon_id' => $this->coupon_id ?? null
            ]);

            // Insert Order Items
            foreach ($this->cart_items as $item) {
                $order->items()->create([
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['total_amount']
                ]);

                $product = Product::find($item['product_id']);

                if ($product) {
                    // Ensure the product has enough stock before decrementing
                    if ($product->quantity >= $item['quantity']) {
                        $product->decrement('quantity', $item['quantity']);
                    } else {
                        throw new \Exception("Not enough stock for product: " . $product->name);
                    }
                }
            }

            $callbackUrl = route('paystack.callback');
            $paystackService = new PaystackService();
            $response = $paystackService->initializePayment(Auth::user()->email, $this->grand_total, $order->reference, $callbackUrl);

            if (isset($response['data']['authorization_url'])) {
                Payment::create([
                    'user_id' => Auth::user()->id,
                    'order_id' => $order->id,
                    'transaction_reference' => $response['data']['reference'],
                    'amount' => $this->grand_total,
                    'payment_method' => $this->paymentMethod,
                    'link' => $response['data']['authorization_url']
                ]);
            }

            DB::commit();

            // Send emails to admin
            $admins = User::where('role', 1)->pluck('email');
            foreach ($admins as $adminEmail) {
                Mail::to($adminEmail)->queue(new NewOrderNotification($order));
            }

            Mail::to(Auth::user()->email)->send(new OrderConfirmation($order, $response['data']['authorization_url']));
            return redirect($response['data']['authorization_url']);
        } catch (\Exception $e) {
            DB::rollBack();
            $this->dispatch('alert-modal', [
                'message' => $e->getMessage(),
                'type' => 'error',
                'product' => 'Error',
            ]);
            return;
        }
    }

    public function render()
    {
        return view('livewire.customer.checkout', [
            'countries' => Country::orderBy('name')->get(),
        ]);
    }
}
