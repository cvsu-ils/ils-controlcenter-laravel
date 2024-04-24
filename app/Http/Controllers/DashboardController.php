<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dashboard;


class DashboardController extends Controller
{
    public function index()
    {
        $collectionsData = Dashboard::where('type', 'collections')
            ->get();
        $facilitiesData = Dashboard::where('type', 'facilities')
            ->get();
        $servicesData = Dashboard::where('type', 'services')
            ->get();
        $utilizationData = Dashboard::where('type', 'Utilizations')
            ->orderByDesc('created_at')
            ->get();
        $satisfactionData = Dashboard::where('type', 'Satisfaction Ratings')
            ->orderByDesc('created_at')
            ->get();
        $linkagesData = Dashboard::where('type', 'linkages')
            ->get();
        $personnelData = Dashboard::where('type', 'personnel')
            ->get();

        $combinedUtilizationData = [];
        $utilizationMap = [];
    
        foreach ($utilizationData as $data) {
            $label = $data->label;
            
            // Check if key property exists in the object
            if (isset($data->key) && isset($data->value)) {
                $key = $data->key;
                $value = $data->value;
    
                // Initialize the label entry if it does not exist
                if (!isset($utilizationMap[$label])) {
                    $utilizationMap[$label] = [
                        'label' => $label,
                        'physical_value' => 0,
                        'online_value' => 0
                    ];
                }
    
                // Calculate physical_value and online_value based on key
                if (strpos($key, 'physical') !== false) {
                    $utilizationMap[$label]['physical_value'] += $value;
                } elseif (strpos($key, 'online') !== false) {
                    $utilizationMap[$label]['online_value'] += $value;
                }
            }
        }
    
        foreach ($utilizationMap as $label => $data) {
            $combinedUtilizationData[] = $data;
        }
    
        return view('dashboard', [
            'collectionsData' => $collectionsData,
            'facilitiesData' => $facilitiesData,
            'servicesData' => $servicesData,
            'utilizationData' => $combinedUtilizationData,
            'satisfactionData' => $satisfactionData,
            'linkagesData' => $linkagesData,
            'personnelData' => $personnelData,
        ]);
    }


/*
Para sa collection
*/
    public function updateCollections(Request $request)
    {
        $request->validate([
            'selectedKeyCollections' => 'required',
            'iconpickerCollections' => 'nullable',
            'collectionsValue' => 'required',
        ]);

        $collections = Dashboard::where('type', 'collections')
            ->where('key', $request->selectedKeyCollections)
            ->first();

        $collections->update([
            'value' => $request->collectionsValue,
            'class_icon' => $request->iconpickerCollections
        ]);

        return response()->json([
            'status' => 'success',
            'message' => $request->selectedKeyCollections . ' updated successfully!'
        ]);
    }



/*
Para sa facilities
*/
    public function updateFacilities(Request $request)
    {
        $request->validate([
            'selectedKeyFacilities' => 'required',
            'iconpickerFacilities' => 'nullable',
            'facilitiesValue' => 'required',
        ]);

        $facilities = Dashboard::where('type', 'facilities')
            ->where('key', $request->selectedKeyFacilities)
            ->first();

        $facilities->update([
            'value' => $request->facilitiesValue,
            'class_icon' => $request->iconpickerFacilities

        ]);

        return response()->json([
            'status' => 'success',
            'message' => $request->selectedKeyFacilities . ' updated successfully!'
        ]);
    }

/*
Para sa services
*/
    public function updateServices(Request $request)
    {
        $request->validate([
            'selectedKeyServices' => 'required',
            'iconpickerServices' => 'nullable',
            'servicesValue' => 'required',
        ]);

        $services = Dashboard::where('type', 'services')
            ->where('key', $request->selectedKeyServices)
            ->first();

        $services->update([
            'value' => $request->servicesValue,
            'class_icon' => $request->iconpickerServices,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => $request->selectedKeyServices . ' updated successfully!'
        ]);
    }

/*
Para sa Utilization
*/
    public function newUtilYear(Request $request)
    {
        // Validate request inputs
        $request->validate([
            'year' => 'required',
            'physicalValueModal' => 'required|numeric',
            'onlineValueModal' => 'required|numeric',
        ]);

        // Check if the year already exists with the label and type 'Utilizations'
        $existingYearUtilization = Dashboard::where('type', 'Utilizations')
            ->where('label', $request->year)
            ->exists();

        if ($existingYearUtilization) {
            return response()->json([
                'status' => 'error',
                'message' => 'Year already exists.'
            ], 400);
        }

        // Create new entries for physical and online utilization
        Dashboard::create([
            'type' => 'Utilizations',
            'label' => $request->year,
            'key' => 'physical-' . $request->year,
            'value' => $request->physicalValueModal,
        ]);
        
        Dashboard::create([
            'type' => 'Utilizations',
            'label' => $request->year,
            'key' => 'online-' . $request->year,
            'value' => $request->onlineValueModal,
        ]);

        // Return success response
        return response()->json([
            'status' => 'success',
            'message' => 'Utilization Year added successfully!'
        ]);
    }



    public function updateUtilYear(Request $request)
    {
        $request->validate([
            'selectedKey' => 'required',
            'physicalValue' => 'required|numeric',
            'onlineValue' => 'required|numeric',
        ]);

        $updatedPhysical = Dashboard::where('type', 'Utilizations')
            ->where('key', 'physical-' . $request->selectedKey)
            ->update(['value' => $request->physicalValue]);

        $updatedOnline = Dashboard::where('type', 'Utilizations')
            ->where('key', 'online-' . $request->selectedKey)
            ->update(['value' => $request->onlineValue]);

        if ($updatedPhysical || $updatedOnline) {
            return response()->json([
                'status' => 'success',
                'message' => 'Utilization data updated successfully!',
            ]);
        } else {
            return response()->json([
                'status' => 'error',
                'message' => 'Utilization data not found for the selected key.',
            ], 400);
        }
    }

/*
Para sa Satisfaction Rating
*/
    public function newSatisYear(Request $request)
    {
        $request->validate([
            'year' => 'required',
            'ratingValueModal' => 'required',
        ]);

        // Check if the year already exists in Satisfaction Ratings
        $existingYearSatisfaction = Dashboard::where('type', 'Satisfaction Ratings')
            ->where('key', $request->year)
            ->first();
        
        if ($existingYearSatisfaction) {
            return response()->json([
                'status' => 'error',
                'message' => 'Year already exists.'
            ], 400);
        }

        Dashboard::create([
            'type' => 'Satisfaction Ratings',
            'label' => $request->year, 
            'key' => $request->year,
            'value' => $request->ratingValueModal
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'New Rating added successfully!'
        ]);
    }

    public function updateSatisYear(Request $request)
    {
        $request->validate([
            'selectedKeySatisfaction' => 'required',
            'ratingValue' => 'required',
        ]);

        // Find the existing Satisfaction Ratings record
        $satisfaction = Dashboard::where('type', 'Satisfaction Ratings')
            ->where('key', $request->selectedKeySatisfaction)
            ->first();

        if (!$satisfaction) {
            return response()->json([
                'status' => 'error',
                'message' => 'Existing Rating not found for the selected year.'
            ], 400);
        }

        // Update Satisfaction Ratings record
        $satisfaction->update([
            'value' => $request->ratingValue
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Rating updated successfully!'
        ]);
    }

/*
Para sa linkages
*/
    public function updateLinkages(Request $request)
    {
        $request->validate([
            'selectedKeyLinkages' => 'required',
            'linkagesValue' => 'required',
        ]);

        $linkages = Dashboard::where('type', 'linkages')
            ->where('key', $request->selectedKeyLinkages)
            ->first();

        $linkages->update([
            'value' => $request->linkagesValue
        ]);

        return response()->json([
            'status' => 'success',
            'message' => $request->selectedKeyLinkages . ' updated successfully!'
        ]);
    }

/*
Para sa Personnel
*/
    public function updatePersonnel(Request $request)
    {
        $request->validate([
            'selectedKeyPersonnel' => 'required',
            'iconpickerPersonnel' => 'nullable',
            'personnelValue' => 'required',
        ]);

        $personnel = Dashboard::where('type', 'personnel')
            ->where('key', $request->selectedKeyPersonnel)
            ->first();

        $personnel->update([
            'value' => $request->personnelValue,
            'class_icon' => $request->iconpickerPersonnel
        ]);

        return response()->json([
            'status' => 'success',
            'message' => $request->selectedKeyPersonnel . ' updated successfully!'
        ]);
    }


}
