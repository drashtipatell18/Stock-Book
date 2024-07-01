<?php

namespace Database\Seeders;

use App\Models\SideBarMenu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SideBarMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SideBarMenu::create([
            'name' => 'fas fa-tachometer-alt',
            'route' => 'dashboard',
            'display_name' => 'Dashboard'
        ]);

        SideBarMenu::create([
            'name' => 'bi bi-calendar-event',
            'route' => 'calendar',
            'display_name' => 'Calendar'
        ]);
        SideBarMenu::create([
            'name' => 'bi bi-tags',
            'route' => 'category',
            'display_name' => 'Category'
        ]);
        SideBarMenu::create([
            'name' => 'bi bi-person-bounding-box',
            'route' => 'role',
            'display_name' => 'Role'
        ]);
        SideBarMenu::create([
            'name' => 'bi bi-person-circle',
            'route' => 'user',
            'display_name' => 'User'
        ]);
        SideBarMenu::create([
            'name' => 'bi bi-people-fill',
            'route' => 'employee',
            'display_name' => 'Employee'
        ]);
        SideBarMenu::create([
            'name' => 'bi bi-person-fill-exclamation',
            'route' => 'leave',
            'display_name' => 'Leave'
        ]);
        SideBarMenu::create([
            'name' => 'bi bi-book-half',
            'route' => 'book',
            'display_name' => 'Book'
        ]);
        SideBarMenu::create([
            'name' => 'bi bi-shop',
            'route' => 'store',
            'display_name' => 'Store'
        ]);
        SideBarMenu::create([
            'name' => 'bi bi-card-checklist',
            'route' => 'stock',
            'display_name' => 'Stock'
        ]);
        SideBarMenu::create([
            'name' => 'bi bi-bag-check',
            'route' => 'salesorder',
            'display_name' => 'Sales Order'
        ]);
        SideBarMenu::create([
            'name' => 'bi bi-receipt-cutoff',
            'route' => 'scrap',
            'display_name' => 'Scrap'
        ]);
        SideBarMenu::create([
            'name' => 'bi bi-credit-card',
            'route' => 'payment',
            'display_name' => 'Payment'
        ]);
        SideBarMenu::create([
            'name' => 'bi bi-bookmark',
            'route' => 'holiday',
            'display_name' => 'Holiday'
        ]);
        SideBarMenu::create([
            'name' => 'bi bi-layout-sidebar',
            'route' => 'sidebar',
            'display_name' => 'Sidebar'
        ]);
        SideBarMenu::create([
            'name' => 'bi bi-gear-fill',
            'route' => 'sidebar.role',
            'display_name' => 'Sidebar Role Management'
        ]);
       
    }
}
