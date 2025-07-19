<?php

namespace App\Http\Controllers\Partner;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Province;
use App\Models\District;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Utility\FileStorage\FileStorageUtility;

class FreelancerController extends Controller
{
    public function index(Request $request)
    {
        $skillFilter    = $request->get('skill');
        $provinceFilter = $request->get('province');
        $districtFilter = $request->get('district');

        $freelancers = User::where('role_id', 1)
            ->when($skillFilter, function ($query, $skillFilter) {
                $query->whereHas('freelancerProfile', function ($q) use ($skillFilter) {
                    $q->whereJsonContains('main_skill', $skillFilter);
                });
            })
            ->when($provinceFilter, function ($query, $provinceFilter) {
                $query->whereHas('freelancerProfile', function ($q) use ($provinceFilter) {
                    $q->where('province_id', $provinceFilter);
                });
            })
            ->when($districtFilter, function ($query, $districtFilter) {
                $query->whereHas('freelancerProfile', function ($q) use ($districtFilter) {
                    $q->where('district_id', $districtFilter);
                });
            })
            ->with([
                'freelancerProfile',
                'freelancerProfile.photoProfile',
                'freelancerProfile.experiences',
                'freelancerProfile.educations',
                'freelancerProfile.achievements',
                'freelancerProfile.skills',
                'freelancerProfile.fileCV',
                'freelancerProfile.fileSKKNI',
                'freelancerProfile.fileSKKK',
                'freelancerProfile.applyJob',
                'freelancerProfile.province',
                'freelancerProfile.district'
            ])
            ->get();


        $provinces = Province::all();

        $districts = $provinceFilter ? District::where('province_id', $provinceFilter)->get() : collect([]);

        Log::info('Fetched Freelancers:', $freelancers->toArray());

        return view('partner.freelancer.index', [
            'pageTitle'     => 'List Konsultan',
            'freelancers'   => $freelancers,
            'skillFilter'   => $skillFilter,
            'provinceFilter' => $provinceFilter,
            'districtFilter' => $districtFilter,
            'provinces'     => $provinces,
            'districts'     => $districts,
        ]);
    }

    public function detail($id)
    {
        $freelancer = User::where('role_id', 1)
            ->with([
                'freelancerProfile',
                'freelancerProfile.photoProfile',
                'freelancerProfile.experiences',
                'freelancerProfile.educations',
                'freelancerProfile.achievements',
                'freelancerProfile.skills',
                'freelancerProfile.fileCV',
                'freelancerProfile.fileSKKNI',
                'freelancerProfile.fileSKKK',
                'freelancerProfile.applyJob',
                'freelancerProfile.province',
                'freelancerProfile.district'
            ])
            ->findOrFail($id);

        return view('partner.freelancer.detail', [
            'pageTitle'  => 'Freelancer Detail',
            'freelancer' => $freelancer,
        ]);
    }
}
