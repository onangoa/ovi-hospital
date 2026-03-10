<?php

namespace App\Http\Controllers;

use App\Models\VitalSignConfig;
use App\Models\ClinicalFormVitalSign;
use Illuminate\Http\Request;

class VitalSignController extends Controller
{
    /**
     * Display the vital signs settings page.
     */
    public function index()
    {
        $vitalSigns = VitalSignConfig::active()->ordered()->get();
        $categories = VitalSignConfig::distinct()->pluck('category')->filter();
        
        return view('vital-signs.index', compact('vitalSigns', 'categories'));
    }

    /**
     * Show the form for creating a new vital sign.
     */
    public function create()
    {
        $categories = VitalSignConfig::distinct()->pluck('category')->filter();
        return view('vital-signs.create', compact('categories'));
    }

    /**
     * Store a newly created vital sign.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'field_name' => 'required|string|max:255|unique:vital_sign_configs,field_name',
            'display_name' => 'required|string|max:255',
            'field_type' => 'required|in:text,number,select',
            'field_options' => 'nullable|string',
            'min_value' => 'nullable|numeric',
            'max_value' => 'nullable|numeric',
            'unit' => 'nullable|string|max:50',
            'display_order' => 'nullable|integer|min:0',
            'is_required' => 'boolean',
            'is_active' => 'boolean',
            'category' => 'required|string|max:100',
        ]);

        // Process field_options from text to array if field_type is select
        if ($validated['field_type'] === 'select' && !empty($validated['field_options'])) {
            $optionsArray = [];
            $lines = explode("\n", trim($validated['field_options']));
            
            foreach ($lines as $line) {
                $line = trim($line);
                if (!empty($line)) {
                    if (strpos($line, ':') !== false) {
                        list($key, $value) = explode(':', $line, 2);
                        $optionsArray[trim($key)] = trim($value);
                    } else {
                        // If no colon, use the line as both key and value
                        $optionsArray[$line] = $line;
                    }
                }
            }
            
            $validated['field_options'] = $optionsArray;
        } else {
            $validated['field_options'] = null;
        }

        VitalSignConfig::create($validated);

        return redirect()->route('vital-signs.index')
            ->with('success', 'Vital sign created successfully.');
    }

    /**
     * Show the form for editing the specified vital sign.
     */
    public function edit(VitalSignConfig $vitalSign)
    {
        $categories = VitalSignConfig::distinct()->pluck('category')->filter();
        return view('vital-signs.edit', compact('vitalSign', 'categories'));
    }

    /**
     * Update the specified vital sign.
     */
    public function update(Request $request, VitalSignConfig $vitalSign)
    {
        $validated = $request->validate([
            'field_name' => 'required|string|max:255|unique:vital_sign_configs,field_name,' . $vitalSign->id,
            'display_name' => 'required|string|max:255',
            'field_type' => 'required|in:text,number,select',
            'field_options' => 'nullable|string',
            'min_value' => 'nullable|numeric',
            'max_value' => 'nullable|numeric',
            'unit' => 'nullable|string|max:50',
            'display_order' => 'nullable|integer|min:0',
            'is_required' => 'boolean',
            'is_active' => 'boolean',
            'category' => 'required|string|max:100',
        ]);

        // Process field_options from text to array if field_type is select
        if ($validated['field_type'] === 'select' && !empty($validated['field_options'])) {
            $optionsArray = [];
            $lines = explode("\n", trim($validated['field_options']));
            
            foreach ($lines as $line) {
                $line = trim($line);
                if (!empty($line)) {
                    if (strpos($line, ':') !== false) {
                        list($key, $value) = explode(':', $line, 2);
                        $optionsArray[trim($key)] = trim($value);
                    } else {
                        // If no colon, use the line as both key and value
                        $optionsArray[$line] = $line;
                    }
                }
            }
            
            $validated['field_options'] = $optionsArray;
        } else {
            $validated['field_options'] = null;
        }

        $vitalSign->update($validated);

        return redirect()->route('vital-signs.index')
            ->with('success', 'Vital sign updated successfully.');
    }

    /**
     * Remove the specified vital sign.
     */
    public function destroy(VitalSignConfig $vitalSign)
    {
        $vitalSign->delete();

        return redirect()->route('vital-signs.index')
            ->with('success', 'Vital sign deleted successfully.');
    }

    /**
     * Display the specified vital sign.
     */
    public function show(VitalSignConfig $vitalSign)
    {
        if (request()->export_pdf) {
            return $this->exportVitalSignPdf($vitalSign);
        }
        
        return view('vital-signs.show', compact('vitalSign'));
    }

    /**
     * Display clinical forms management page.
     */
    public function clinicalFormsIndex()
    {
        $clinicalForms = ClinicalFormVitalSign::active()->get();
        return view('vital-signs.clinical-forms', compact('clinicalForms'));
    }

    /**
     * Show the form for configuring vital signs for a clinical form.
     */
    public function configureClinicalForm(ClinicalFormVitalSign $clinicalForm)
    {
        $clinicalForm->load('vitalSigns');
        $availableVitalSigns = VitalSignConfig::active()->ordered()->get();
        
        return view('vital-signs.configure-form', compact('clinicalForm', 'availableVitalSigns'));
    }

    /**
     * Update vital signs configuration for a clinical form.
     */
    public function updateClinicalForm(Request $request, ClinicalFormVitalSign $clinicalForm)
    {
        // Filter out empty vital_sign_config_id values before validation
        $vitalSigns = collect($request->input('vital_signs', []))->filter(function ($item) {
            return !empty($item['vital_sign_config_id']);
        })->toArray();

        $request->merge(['vital_signs' => $vitalSigns]);

        $validated = $request->validate([
            'vital_signs' => 'nullable|array',
            'vital_signs.*.vital_sign_config_id' => 'required|exists:vital_sign_configs,id',
            'vital_signs.*.is_required' => 'boolean',
            'vital_signs.*.display_order' => 'nullable|integer|min:0',
        ]);

        // Detach all existing vital signs
        $clinicalForm->vitalSigns()->detach();

        // Attach the selected vital signs
        if (isset($validated['vital_signs'])) {
            foreach ($validated['vital_signs'] as $vitalSignData) {
                $clinicalForm->vitalSigns()->attach($vitalSignData['vital_sign_config_id'], [
                    'is_required' => $vitalSignData['is_required'] ?? false,
                    'display_order' => $vitalSignData['display_order'] ?? 0,
                ]);
            }
        }

        return redirect()->route('vital-signs.clinical-forms')
            ->with('success', 'Clinical form configuration updated successfully.');
    }

    /**
     * Get vital signs for a specific clinical form (AJAX endpoint).
     */
    public function getVitalSignsForForm($formName)
    {
        $clinicalForm = ClinicalFormVitalSign::where('form_name', $formName)
            ->active()
            ->with('vitalSigns')
            ->first();

        if (!$clinicalForm) {
            return response()->json(['error' => 'Form not found'], 404);
        }

        $vitalSigns = $clinicalForm->vitalSigns->map(function ($vitalSign) {
            return [
                'id' => $vitalSign->id,
                'field_name' => $vitalSign->field_name,
                'display_name' => $vitalSign->display_name,
                'field_type' => $vitalSign->field_type,
                'field_options' => $vitalSign->field_options,
                'min_value' => $vitalSign->min_value,
                'max_value' => $vitalSign->max_value,
                'unit' => $vitalSign->unit,
                'is_required' => $vitalSign->pivot->is_required,
                'display_order' => $vitalSign->pivot->display_order,
            ];
        });

        return response()->json($vitalSigns);
    }

    /**
     * Export individual vital sign to PDF
     *
     * @param VitalSignConfig $vitalSign
     * @return \Illuminate\Http\Response
     */
    private function exportVitalSignPdf(VitalSignConfig $vitalSign)
    {
        $pdfExport = new VitalSignPdfExport($vitalSign);
        return $pdfExport->download();
    }
}