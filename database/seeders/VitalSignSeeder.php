<?php

namespace Database\Seeders;

use App\Models\VitalSignConfig;
use App\Models\ClinicalFormVitalSign;
use Illuminate\Database\Seeder;

class VitalSignSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create default vital signs
        $vitalSigns = [
            [
                'field_name' => 'temperature',
                'display_name' => 'Temperature',
                'field_type' => 'number',
                'min_value' => 35.0,
                'max_value' => 42.0,
                'unit' => '°C',
                'display_order' => 1,
                'is_required' => true,
                'is_active' => true,
                'category' => 'general',
            ],
            [
                'field_name' => 'systolic_bp',
                'display_name' => 'Systolic BP',
                'field_type' => 'number',
                'min_value' => 70,
                'max_value' => 250,
                'unit' => 'mmHg',
                'display_order' => 2,
                'is_required' => true,
                'is_active' => true,
                'category' => 'general',
            ],
            [
                'field_name' => 'diastolic_bp',
                'display_name' => 'Diastolic BP',
                'field_type' => 'number',
                'min_value' => 40,
                'max_value' => 150,
                'unit' => 'mmHg',
                'display_order' => 3,
                'is_required' => true,
                'is_active' => true,
                'category' => 'general',
            ],
            [
                'field_name' => 'pulse_rate',
                'display_name' => 'Pulse Rate',
                'field_type' => 'number',
                'min_value' => 40,
                'max_value' => 200,
                'unit' => 'bpm',
                'display_order' => 4,
                'is_required' => true,
                'is_active' => true,
                'category' => 'general',
            ],
            [
                'field_name' => 'respiratory_rate',
                'display_name' => 'Respiratory Rate',
                'field_type' => 'number',
                'min_value' => 8,
                'max_value' => 40,
                'unit' => '/min',
                'display_order' => 5,
                'is_required' => true,
                'is_active' => true,
                'category' => 'general',
            ],
            [
                'field_name' => 'oxygen_saturation',
                'display_name' => 'Oxygen Saturation',
                'field_type' => 'number',
                'min_value' => 70,
                'max_value' => 100,
                'unit' => '%',
                'display_order' => 6,
                'is_required' => true,
                'is_active' => true,
                'category' => 'general',
            ],
            [
                'field_name' => 'hb',
                'display_name' => 'Hb',
                'field_type' => 'number',
                'min_value' => 5.0,
                'max_value' => 20.0,
                'unit' => 'g/dL',
                'display_order' => 7,
                'is_required' => false,
                'is_active' => true,
                'category' => 'laboratory',
            ],
            [
                'field_name' => 'rbs',
                'display_name' => 'RBS',
                'field_type' => 'number',
                'min_value' => 50,
                'max_value' => 400,
                'unit' => 'mg/dL',
                'display_order' => 8,
                'is_required' => false,
                'is_active' => true,
                'category' => 'laboratory',
            ],
            [
                'field_name' => 'pain_score',
                'display_name' => 'Pain Score',
                'field_type' => 'select',
                'field_options' => ['0' => 'No Pain', '1' => 'Mild', '2' => 'Moderate', '3' => 'Severe', '4' => 'Worst Possible'],
                'min_value' => 0,
                'max_value' => 4,
                'unit' => '0-10 scale',
                'display_order' => 9,
                'is_required' => false,
                'is_active' => true,
                'category' => 'subjective',
            ],
        ];

        foreach ($vitalSigns as $vitalSign) {
            VitalSignConfig::create($vitalSign);
        }

        // Create clinical forms
        $clinicalForms = [
            [
                'form_name' => 'initial_evaluation',
                'form_display_name' => 'Initial Evaluation',
                'is_active' => true,
                'description' => 'Initial patient evaluation form',
            ],
            [
                'form_name' => 'lab_request',
                'form_display_name' => 'Lab Request',
                'is_active' => true,
                'description' => 'Laboratory request form',
            ],
            [
                'form_name' => 'nursing_cardex',
                'form_display_name' => 'Nursing Cardex',
                'is_active' => true,
                'description' => 'Nursing cardex form',
            ],
            [
                'form_name' => 'ward_round_notes',
                'form_display_name' => 'Ward Round Notes',
                'is_active' => true,
                'description' => 'Ward round notes form',
            ],
            [
                'form_name' => 'medical_referral',
                'form_display_name' => 'Medical Referral',
                'is_active' => true,
                'description' => 'Medical referral form',
            ],
            [
                'form_name' => 'weekly_wellness_check',
                'form_display_name' => 'Weekly Wellness Check',
                'is_active' => true,
                'description' => 'Weekly wellness check form',
            ],
        ];

        foreach ($clinicalForms as $form) {
            ClinicalFormVitalSign::create($form);
        }

        // Assign vital signs to clinical forms
        $this->assignVitalSignsToForms();
    }

    private function assignVitalSignsToForms()
    {
        // Get all vital signs
        $allVitalSigns = VitalSignConfig::active()->get();
        
        // Get all clinical forms
        $clinicalForms = ClinicalFormVitalSign::active()->get();

        foreach ($clinicalForms as $form) {
            $vitalSignsToAssign = [];
            
            switch ($form->form_name) {
                case 'initial_evaluation':
                case 'ward_round_notes':
                case 'nursing_cardex':
                    // Assign all vital signs
                    $vitalSignsToAssign = $allVitalSigns;
                    break;
                    
                case 'lab_request':
                    // Assign basic vital signs plus pain score
                    $vitalSignsToAssign = $allVitalSigns->filter(function ($vs) {
                        return in_array($vs->field_name, [
                            'temperature', 'systolic_bp', 'diastolic_bp', 
                            'pulse_rate', 'respiratory_rate', 'oxygen_saturation', 'pain_score'
                        ]);
                    });
                    break;
                    
                case 'medical_referral':
                    // Assign basic vital signs
                    $vitalSignsToAssign = $allVitalSigns->filter(function ($vs) {
                        return in_array($vs->field_name, [
                            'temperature', 'systolic_bp', 'diastolic_bp', 
                            'pulse_rate', 'respiratory_rate', 'oxygen_saturation'
                        ]);
                    });
                    break;
                    
                case 'weekly_wellness_check':
                    // Assign basic vital signs
                    $vitalSignsToAssign = $allVitalSigns->filter(function ($vs) {
                        return in_array($vs->field_name, [
                            'temperature', 'systolic_bp', 'diastolic_bp', 
                            'pulse_rate', 'respiratory_rate', 'oxygen_saturation'
                        ]);
                    });
                    break;
            }

            // Attach vital signs to the form
            $displayOrder = 1;
            foreach ($vitalSignsToAssign as $vitalSign) {
                $isRequired = in_array($vitalSign->field_name, [
                    'temperature', 'systolic_bp', 'diastolic_bp', 'pulse_rate', 'respiratory_rate', 'oxygen_saturation'
                ]);

                $form->vitalSigns()->attach($vitalSign->id, [
                    'is_required' => $isRequired,
                    'display_order' => $displayOrder++,
                ]);
            }
        }
    }
}