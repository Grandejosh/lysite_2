<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\User;
use Livewire\Component;
use Modules\Academic\Entities\AcaCourse;
use Modules\Academic\Entities\AcaStudent;

class DashboardAdminQuantities extends Component
{
    public $quantity_users;
    public $quantity_students;
    public $quantity_courses;

    public function mount(){
        $this->quantity_users = User::count();
        $this->quantity_students = AcaStudent::count('person_id');
        $this->quantity_courses = AcaCourse::count();
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard-admin-quantities');
    }
}
