<?php

namespace App\Livewire\Admin;

use App\Models\Coupon;
use Flux\Flux;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;
use Livewire\Component;

#[Layout('layouts.admin.layout')]

class CouponCodes extends Component
{
    #[Validate('required|string|unique:coupons|min:2')]
    public $code;

    #[Validate('required|numeric|max:90')]
    public $discount;
    #[Validate('required|date')]
    public $startDate;
    #[Validate('required|date')]
    public $endDate;
    public $couponId = null;
    public $editCode, $editDiscount, $editStartDate, $editEndDate;

    public function storeCoupon()
    {
        $this->validate([
            'code' => 'required|string|unique:coupons|min:2',
            'discount' => 'required|numeric|max:90',
            'startDate' => 'required|date',
            'endDate' => 'required|date|after:startDate'
        ]);

        Coupon::create([
            'code' => str($this->code)->trim()->upper(),
            'discount_percentage' => str($this->discount)->trim(),
            'start_date' => $this->startDate,
            'end_date' => $this->endDate
        ]);
        session()->flash('success', 'new coupon created');
        $this->reset();
    }

    #[On('open-coupon-modal')]
    public function confirmEdit($mode, $coupon)
    {
        $coupon = Coupon::findOrFail($coupon);
        if ($coupon) {
            $this->editCode = $coupon->code;
            $this->editDiscount = $coupon->discount_percentage;
            $this->editStartDate = $coupon->start_date;
            $this->editEndDate = $coupon->end_date;
            $this->couponId = $coupon->id;
        } else {
            return redirect()->route('admin.coupons');
        }
    }

    public function updateCoupon()
    {
        $coupon = Coupon::findOrFail($this->couponId);
        $this->validate([
            'editDiscount' => 'required|numeric|max:90',
            'editStartDate' => 'required|date',
            'editEndDate' => 'required|date|after:editStartDate'
        ]);
        $coupon->update([
            'discount_percentage' => str($this->editDiscount)->trim(),
            'start_date' => $this->editStartDate,
            'end_date' => $this->editEndDate,
        ]);

        Flux::modal('edit-coupon')->close();
        session()->flash('success', 'coupon updated');
        $this->reset();
    }

    #[On('delete-coupon')]
    public function deleteConfirmation($id)
    {
        $this->couponId = $id;
    }

    public function deleteCoupon()
    {
        if ($this->couponId) {
            $coupon = Coupon::findOrFail($this->couponId);
            if ($coupon) {
                $coupon->delete();
                Flux::modal('delete-coupon')->close();
                session()->flash('success', 'Coupon deleted successfully!');
                $this->reset();
            } else {
                Flux::modal('delete-coupon')->close();
                return redirect()->route('admin.coupons');
            }
        }
    }
    public function render()
    {
        $coupons = Coupon::all();
        return view('livewire.admin.coupon-codes', [
            'coupons' => $coupons
        ]);
    }
}
