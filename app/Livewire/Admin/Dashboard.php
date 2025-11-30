<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductReview;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('layouts.admin.layout')]
class Dashboard extends Component
{
    public $totalOrders;
    public $totalProducts;
    public $totalRevenue;
    public $totalUsers;
    public $pendingReviews;
    public $recentOrders = [];
    public $categoryChartData = [];
    public $lineGraphData;

    public function mount()
    {
        $this->authorizeAccess();
        $this->loadDashboardData();
        $this->loadLineGraphData();
    }

    protected function authorizeAccess()
    {
        if (!Auth::user() || Auth::user()->role !== 1) {
            return redirect(route('home'));
        }
    }


    protected function loadLineGraphData()
    {
        // Generate last 7 days date range
        $days = collect();
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $days->push([
                'date' => $date->toDateString(),
                'day'  => $date->isToday() ? 'Today' : $date->format('l'),
                'revenue' => 0,
            ]);
        }

        // Fetch sales for the last 7 days
        $sales = DB::table('orders')
            ->selectRaw('DATE(created_at) as date, SUM(total_price) as revenue')
            ->where('status', 'delivered')
            ->where('created_at', '>=', now()->subDays(6)->startOfDay())
            ->groupBy('date')
            ->pluck('revenue', 'date');

        // Merge sales into the full date list
        $result = $days->map(function ($day) use ($sales) {
            return [
                'day' => $day['day'],
                'revenue' => isset($sales[$day['date']]) ? (float) $sales[$day['date']] : 0,
            ];
        });

        $this->lineGraphData = $result->toArray();
    }


    protected function loadDashboardData()
    {
        $this->totalOrders = Order::all()->count();
        $this->totalProducts = Product::all()->count();
        $this->totalUsers = User::where('role', 2)->count();
        $this->pendingReviews = ProductReview::where('status', 'pending')->count();
        $this->recentOrders = Order::with('user')->latest()->take(7)->get();
        $this->totalRevenue = Order::where('status', 'delivered')->sum('total_price');
        $this->categoryChartData = $this->getCategorySalesChartData();
    }

    protected function getCategorySalesChartData()
    {
        $fromDate = Carbon::now()->subDays(30);
        $toDate = Carbon::now();

        $categories = Category::with(['products' => function ($query) use ($fromDate, $toDate) {
            $query->whereHas('orderItems.order', function ($q) use ($fromDate, $toDate) {
                $q->whereBetween('created_at', [$fromDate, $toDate])
                    ->where('status', 'delivered');
            });
        }])->get();

        $data = [];

        foreach ($categories as $category) {
            $sold = 0;
            $revenue = 0;

            foreach ($category->products as $pd) {
                foreach ($pd->orderItems as $item) {
                    $sold += $item->quantity;
                    $revenue += $item->quantity * $item->price;
                }
            }

            if ($sold > 0) {
                $data[] = [
                    'label' => $category->name,
                    'quantity' => $sold,
                    'revenue' => $revenue
                ];
            }
        }
        // dd($data);
        return $data;
    }
    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
