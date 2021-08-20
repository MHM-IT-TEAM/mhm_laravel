<?php

namespace Database\Seeders;

use App\Models\DiagCode;
use Illuminate\Database\Seeder;

class DiagCodeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        return DiagCode::insert([
            ['code'=>'D01','description'=>'General Danger Sign'],
            ['code'=>'D02','description'=>'Diarrhea'],
            ['code'=>'D03','description'=>'Cough or cold'],
            ['code'=>'D04','description'=>'Pneumonia'],
            ['code'=>'D05','description'=>'Other acute renal failure'],
            ['code'=>'D06','description'=>'Asthma'],
            ['code'=>'D07','description'=>'Diphtheria'],
            ['code'=>'D08','description'=>'Whooping cough'],
            ['code'=>'D09','description'=>'Tetanus'],
            ['code'=>'D10','description'=>'Acute flaccid paralysis'],
            ['code'=>'D11','description'=>'Genital discharge'],
            ['code'=>'D12','description'=>'Genital ulceration'],
            ['code'=>'D13','description'=>'HIV infection'],
            ['code'=>'D14','description'=>'Simple malaria'],
            ['code'=>'D15','description'=>'Simple malaria of a pregnant woman'],
            ['code'=>'D16','description'=>'Severe malaria'],
            ['code'=>'D17','description'=>'Cough more than 3 weeks,suspicion of tuberculosis'],
            ['code'=>'D18','description'=>'Tuberculosis confirmed Bacilloscopic'],
            ['code'=>'D19','description'=>'Pauci Bacillary (PB) Leprosy'],
            ['code'=>'D20','description'=>'Pauci Bacillary (PB ) Leprosy having d'],
            ['code'=>'D21','description'=>'Multi Bacillary (MB) Leprosy'],
            ['code'=>'D22','description'=>'MB Leprosy having 2 degree 2 infirmity'],
            ['code'=>'D23','description'=>'Anemia'],
            ['code'=>'D24','description'=>'Severe anemia'],
            ['code'=>'D25','description'=>'underweight'],
            ['code'=>'D26','description'=>'Severe acute malnutrition'],
            ['code'=>'D27','description'=>'Overweight/Obesity'],
            ['code'=>'D28','description'=>'Growth retardation'],
            ['code'=>'D29','description'=>'Otitis'],
            ['code'=>'D30','description'=>'Hearing impairment'],
            ['code'=>'D31','description'=>'Traumatic red eye'],
            ['code'=>'D32','description'=>'Non traumatic red eye and non conjunctivitis'],
            ['code'=>'D33','description'=>'Visual impairment'],
            ['code'=>'D34','description'=>'suspected cataract'],
            ['code'=>'D35','description'=>'Dental cavities'],
            ['code'=>'D36','description'=>'Epilepsy'],
            ['code'=>'D37','description'=>'Mental disorders'],
            ['code'=>'D38','description'=>'High blood pressure'],
            ['code'=>'D39','description'=>'Stroke'],
            ['code'=>'D40','description'=>'Suspected diabetes'],
            ['code'=>'D41','description'=>'Suspected sickle cell anemia'],
            ['code'=>'D42','description'=>'Hydrocede'],
            ['code'=>'D43','description'=>'Lymphoedema'],
            ['code'=>'D44','description'=>'Precancerous cervical lesions (IVA+)'],
            ['code'=>'D45','description'=>'Other new cases of priority diseases'],
            ['code'=>'D46','description'=>'Feverish illnesses from all causes'],
            ['code'=>'D47','description'=>'Suspected measles'],
            ['code'=>'D48','description'=>'Suspected meningitis'],
            ['code'=>'D49','description'=>'Suspected flu(Cough+Fever)'],
            ['code'=>'D50','description'=>'Suspected Arborivus (Dengue,Chikungunya) '],
            ['code'=>'D51','description'=>'Suspected Rift Valley Fever'],
            ['code'=>'D52','description'=>'Other Hemorrhagic fevers'],
            ['code'=>'D53','description'=>'Toxic collective food infection'],
            ['code'=>'D54','description'=>'Intoxication by consumption of marine animals'],
            ['code'=>'D55','description'=>'Bites/ scratches by warm-blooded animal'],
            ['code'=>'D56','description'=>'Other epidemic diseases'],
            ['code'=>'D57','description'=>'Sexual violence'],
            ['code'=>'D58','description'=>'Other violence'],
            ['code'=>'D59','description'=>'Traffic accidents'],
            ['code'=>'D60','description'=>'Work accidents'],
            ['code'=>'D61','description'=>'Suicide'],
            ['code'=>'D62','description'=>'Other cases of trauma'],
        ]);

    }
}
