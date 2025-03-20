<?php

// app/Http/Controllers/ApplicationController.php
namespace App\Http\Controllers;

use App\Http\Requests\ApplicationStep1Request;
use App\Http\Requests\ApplicationStep2Request;
use App\Http\Requests\ApplicationStep3Request;
use App\Http\Requests\ApplicationStep4Request;
use App\Http\Requests\PaymentRequest;
use App\Domain\Services\ApplicationService;
use App\Models\Advertisement;
use App\Models\Application;
use App\Models\CurrentEnrollment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Models\UpscAttempt;
// use Barryvdh\DomPDF\Facade as PDF;
use Barryvdh\DomPDF\Facade\Pdf as PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;


class ApplicationController extends Controller
{
    private $applicationService;

    public function __construct(ApplicationService $applicationService)
    {
        $this->applicationService = $applicationService;
    }

    public function create(Advertisement $advertisement)
    {
        // dd($advertisement->id);
        $advertisementId = $advertisement->id;
        // Enable query logging
        \DB::enableQueryLog();

        // $advertisement = Advertisement::with('programs')->findOrFail($advertisementId);
        $student = Auth::user();
        // $profile = $student->profiles()->where('is_current', true)->first();
        // 
        $application = $student->applications()
        ->where('advertisement_id', $advertisementId)
        ->first();

        if (!is_null($application)) {

            if ($application->student_id !== auth()->id()) {
                abort(403, 'Unauthorized access to this application');
            }

            if ($application->status == 'submitted') {
                return redirect()->route('dashboard')
                ->with('toastr', ['type' => 'error', 'message' => 'Your application has already been submitted.']);
            }
        }
        
        // dd($application);
        if($application === null){
            // dd('No rows found Means Need to Create');
            // If no application record was found of that advertisement Id, that means applying for first time and will be create, not update
            $profile = $student->profiles()->where('is_current', true)->first();
        }else{
            // dd('Rows found Means need to Update');
            $profile = $student->profiles()->where('id', $application->student_profile_id)->first();
            // dd($profile);
        }
        // dd($application);
        
        // dd($advertisement->programs);


        // Get the logged queries
        $queries = \DB::getQueryLog();
    
        // dd($advertisement); // Output all executed queries

        return view('applications.step1', compact('advertisement', 'student', 'profile', 'application'));
    }

    public function storeStep1(ApplicationStep1Request $request, Advertisement $advertisement)
    {
        $advertisementId = $advertisement->id;
        $advertisement = Advertisement::findOrFail($advertisementId);
        try {
            $application = $this->applicationService->startApplication(
                Auth::id(),
                $advertisementId,
                $request->validated()
            );
            // dd($application);

            return redirect()->route('application.step2', $application)
                ->with('toastr', ['type' => 'success', 'message' => 'Step 1 completed!']);
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('toastr', ['type' => 'error', 'message' => 'Failed to save step 1']);
        }
    }

    // 
    // public function step2($applicationId)
    // {
    //     $application = Application::findOrFail($applicationId);
    //     $student = Auth::user();
        
    //     // $addresses = $this->applicationService->addressRepository->getByApplicationId($applicationId);
    //     $addresses = $this->applicationService->getAddressByApplicationId($applicationId);
    //     if ($addresses->isEmpty()) {
    //         $addresses = $student->addresses;
    //     }
        
    //     // $academics = $this->applicationService->academicRepository->getByApplicationId($applicationId);
    //     $academics = $this->applicationService->getAcademicByApplicationId($applicationId);
    //     if ($academics->isEmpty()) {
    //         $academics = $student->academicQualifications;
    //     }

    //     return view('applications.step2', compact('application', 'addresses', 'academics'));
    // }

    public function step2(Application $application)
    {
        if ($application->student_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this application');
        }

        if ($application->status == 'submitted') {
            return redirect()->route('dashboard')
            ->with('toastr', ['type' => 'error', 'message' => 'Your application has already been submitted.']);
        }

        $applicationId = $application->id;
        $application = Application::findOrFail($applicationId);
        $student = Auth::user();
        
        $advertisement = Advertisement::with('programs')->findOrFail($application->advertisement_id);
        
        $addresses = $this->applicationService->getAddressByApplicationId($applicationId);
        if ($addresses->isEmpty()) {
            $addresses = $student->addresses;
        }
        
        $academics = $this->applicationService->getAcademicByApplicationId($applicationId);
        if ($academics->isEmpty()) {
            $academics = $student->academicQualifications;
        }
    
        // Define your state-district data here or fetch from a model/service
        // $stateDistrictData = [
        //     "Maharashtra" => ["Mumbai", "Pune", "Nagpur"],
        //     "Delhi" => ["New Delhi", "North Delhi", "South Delhi"],
        //     "Karnataka" => ["Bangalore", "Mysore", "Hubli"]
        // ];
        $stateDistrictData = [
            "Andhra Pradesh" => [
                "Anantapur", "Chittoor", "East Godavari", "Guntur", "Krishna", "Kurnool", 
                "Prakasam", "Srikakulam", "Visakhapatnam", "Vizianagaram", "West Godavari", 
                "YSR Kadapa", "Nellore", "Alluri Sitharama Raju", "Anakapalli", "Bapatla", 
                "Eluru", "Kakinada", "Konaseema", "Nandyal", "Palnadu", "Parvathipuram Manyam", 
                "Sri Sathya Sai", "Tirupati"
            ],
            "Arunachal Pradesh" => [
                "Tawang", "West Kameng", "East Kameng", "Papum Pare", "Kurung Kumey", 
                "Kra Daadi", "Lower Subansiri", "Upper Subansiri", "West Siang", "East Siang", 
                "Siang", "Upper Siang", "Lower Siang", "Lower Dibang Valley", "Dibang Valley", 
                "Anjaw", "Lohit", "Namsai", "Changlang", "Tirap", "Longding", "Kamle", 
                "Pakke-Kessang", "Lepa Rada", "Shi-Yomi"
            ],
            "Assam" => [
                "Baksa", "Barpeta", "Biswanath", "Bongaigaon", "Cachar", "Charaideo", 
                "Chirang", "Darrang", "Dhemaji", "Dhubri", "Dibrugarh", "Dima Hasao", 
                "Goalpara", "Golaghat", "Hailakandi", "Hojai", "Jorhat", "Kamrup", 
                "Kamrup Metropolitan", "Karbi Anglong", "Karimganj", "Kokrajhar", "Lakhimpur", 
                "Majuli", "Morigaon", "Nagaon", "Nalbari", "Sivasagar", "Sonitpur", 
                "South Salmara-Mankachar", "Tinsukia", "Udalguri", "West Karbi Anglong"
            ],
            "Bihar" => [
                "Araria", "Arwal", "Aurangabad", "Banka", "Begusarai", "Bhagalpur", "Bhojpur", 
                "Buxar", "Darbhanga", "East Champaran", "Gaya", "Gopalganj", "Jamui", 
                "Jehanabad", "Kaimur", "Katihar", "Khagaria", "Kishanganj", "Lakhisarai", 
                "Madhepura", "Madhubani", "Munger", "Muzaffarpur", "Nalanda", "Nawada", 
                "Patna", "Purnia", "Rohtas", "Saharsa", "Samastipur", "Saran", "Sheikhpura", 
                "Sheohar", "Sitamarhi", "Siwan", "Supaul", "Vaishali", "West Champaran"
            ],
            "Chhattisgarh" => [
                "Balod", "Baloda Bazar", "Balrampur", "Bastar", "Bemetara", "Bijapur", 
                "Bilaspur", "Dantewada", "Dhamtari", "Durg", "Gariaband", "Gaurela-Pendra-Marwahi", 
                "Janjgir-Champa", "Jashpur", "Kabirdham", "Kanker", "Kondagaon", "Korba", 
                "Koriya", "Mahasamund", "Mungeli", "Narayanpur", "Raigarh", "Raipur", 
                "Rajnandgaon", "Sukma", "Surajpur", "Surguja"
            ],
            "Goa" => [
                "North Goa", "South Goa"
            ],
            "Gujarat" => [
                "Ahmedabad", "Amreli", "Anand", "Aravalli", "Banaskantha", "Bharuch", 
                "Bhavnagar", "Botad", "Chhota Udaipur", "Dahod", "Dang", "Devbhoomi Dwarka", 
                "Gandhinagar", "Gir Somnath", "Jamnagar", "Junagadh", "Kheda", "Kutch", 
                "Mahisagar", "Mehsana", "Morbi", "Narmada", "Navsari", "Panchmahal", 
                "Patan", "Porbandar", "Rajkot", "Sabarkantha", "Surat", "Surendranagar", 
                "Tapi", "Vadodara", "Valsad"
            ],
            "Haryana" => [
                "Ambala", "Bhiwani", "Charkhi Dadri", "Faridabad", "Fatehabad", "Gurugram", 
                "Hisar", "Jhajjar", "Jind", "Kaithal", "Karnal", "Kurukshetra", "Mahendragarh", 
                "Nuh", "Palwal", "Panchkula", "Panipat", "Rewari", "Rohtak", "Sirsa", 
                "Sonipat", "Yamunanagar"
            ],
            "Himachal Pradesh" => [
                "Bilaspur", "Chamba", "Hamirpur", "Kangra", "Kinnaur", "Kullu", "Lahaul and Spiti", 
                "Mandi", "Shimla", "Sirmaur", "Solan", "Una"
            ],
            "Jharkhand" => [
                "Bokaro", "Chatra", "Deoghar", "Dhanbad", "Dumka", "East Singhbhum", 
                "Garhwa", "Giridih", "Godda", "Gumla", "Hazaribagh", "Jamtara", "Khunti", 
                "Koderma", "Latehar", "Lohardaga", "Pakur", "Palamu", "Ramgarh", "Ranchi", 
                "Sahebganj", "Seraikela Kharsawan", "Simdega", "West Singhbhum"
            ],
            "Karnataka" => [
                "Bagalkot", "Ballari", "Belagavi", "Bengaluru Rural", "Bengaluru Urban", 
                "Bidar", "Chamarajanagar", "Chikkaballapur", "Chikkamagaluru", "Chitradurga", 
                "Dakshina Kannada", "Davanagere", "Dharwad", "Gadag", "Hassan", "Haveri", 
                "Kalaburagi", "Kodagu", "Kolar", "Koppal", "Mandya", "Mysuru", "Raichur", 
                "Ramanagara", "Shivamogga", "Tumakuru", "Udupi", "Uttara Kannada", "Vijayapura", 
                "Yadgir"
            ],
            "Kerala" => [
                "Alappuzha", "Ernakulam", "Idukki", "Kannur", "Kasaragod", "Kollam", 
                "Kottayam", "Kozhikode", "Malappuram", "Palakkad", "Pathanamthitta", 
                "Thiruvananthapuram", "Thrissur", "Wayanad"
            ],
            "Madhya Pradesh" => [
                "Agar Malwa", "Alirajpur", "Anuppur", "Ashoknagar", "Balaghat", "Barwani", 
                "Betul", "Bhind", "Bhopal", "Burhanpur", "Chhatarpur", "Chhindwara", 
                "Damoh", "Datia", "Dewas", "Dhar", "Dindori", "Guna", "Gwalior", "Harda", 
                "Hoshangabad", "Indore", "Jabalpur", "Jhabua", "Katni", "Khandwa", "Khargone", 
                "Mandla", "Mandsaur", "Morena", "Narsinghpur", "Neemuch", "Niwari", "Panna", 
                "Raisen", "Rajgarh", "Ratlam", "Rewa", "Sagar", "Satna", "Sehore", "Seoni", 
                "Shahdol", "Shajapur", "Sheopur", "Shivpuri", "Sidhi", "Singrauli", "Tikamgarh", 
                "Ujjain", "Umaria", "Vidisha"
            ],
            "Maharashtra" => [
                "Ahmednagar", "Akola", "Amravati", "Aurangabad", "Beed", "Bhandara", 
                "Buldhana", "Chandrapur", "Dhule", "Gadchiroli", "Gondia", "Hingoli", 
                "Jalgaon", "Jalna", "Kolhapur", "Latur", "Mumbai City", "Mumbai Suburban", 
                "Nagpur", "Nanded", "Nandurbar", "Nashik", "Osmanabad", "Palghar", "Parbhani", 
                "Pune", "Raigad", "Ratnagiri", "Sangli", "Satara", "Sindhudurg", "Solapur", 
                "Thane", "Wardha", "Washim", "Yavatmal"
            ],
            "Manipur" => [
                "Bishnupur", "Chandel", "Churachandpur", "Imphal East", "Imphal West", 
                "Jiribam", "Kakching", "Kamjong", "Kangpokpi", "Noney", "Pherzawl", 
                "Senapati", "Tamenglong", "Tengnoupal", "Thoubal", "Ukhrul"
            ],
            "Meghalaya" => [
                "East Garo Hills", "East Jaintia Hills", "East Khasi Hills", "North Garo Hills", 
                "Ri-Bhoi", "South Garo Hills", "South West Garo Hills", "South West Khasi Hills", 
                "West Garo Hills", "West Jaintia Hills", "West Khasi Hills"
            ],
            "Mizoram" => [
                "Aizawl", "Champhai", "Hnahthial", "Khawzawl", "Kolasib", "Lawngtlai", 
                "Lunglei", "Mamit", "Saiha", "Saitual", "Serchhip"
            ],
            "Nagaland" => [
                "Chumoukedima", "Dimapur", "Kiphire", "Kohima", "Longleng", "Mokokchung", 
                "Mon", "Niuland", "Noklak", "Peren", "Phek", "Shamator", "Tseminyu", 
                "Tuensang", "Wokha", "Zunheboto"
            ],
            "Odisha" => [
                "Angul", "Balangir", "Balasore", "Bargarh", "Bhadrak", "Boudh", "Cuttack", 
                "Deogarh", "Dhenkanal", "Gajapati", "Ganjam", "Jagatsinghpur", "Jajpur", 
                "Jharsuguda", "Kalahandi", "Kandhamal", "Kendrapara", "Kendujhar", "Khordha", 
                "Koraput", "Malkangiri", "Mayurbhanj", "Nabarangpur", "Nayagarh", "Nuapada", 
                "Puri", "Rayagada", "Sambalpur", "Subarnapur", "Sundargarh"
            ],
            "Punjab" => [
                "Amritsar", "Barnala", "Bathinda", "Faridkot", "Fatehgarh Sahib", "Fazilka", 
                "Ferozepur", "Gurdaspur", "Hoshiarpur", "Jalandhar", "Kapurthala", "Ludhiana", 
                "Malerkotla", "Mansa", "Moga", "Muktsar", "Pathankot", "Patiala", "Rupnagar", 
                "Sangrur", "SAS Nagar", "Shaheed Bhagat Singh Nagar", "Tarn Taran"
            ],
            "Rajasthan" => [
                "Ajmer", "Alwar", "Banswara", "Baran", "Barmer", "Bharatpur", "Bhilwara", 
                "Bikaner", "Bundi", "Chittorgarh", "Churu", "Dausa", "Dholpur", "Dungarpur", 
                "Hanumangarh", "Jaipur", "Jaisalmer", "Jalore", "Jhalawar", "Jhunjhunu", 
                "Jodhpur", "Karauli", "Kota", "Nagaur", "Pali", "Pratapgarh", "Rajsamand", 
                "Sawai Madhopur", "Sikar", "Sirohi", "Sri Ganganagar", "Tonk", "Udaipur"
            ],
            "Sikkim" => [
                "East Sikkim", "North Sikkim", "South Sikkim", "West Sikkim"
            ],
            "Tamil Nadu" => [
                "Ariyalur", "Chengalpattu", "Chennai", "Coimbatore", "Cuddalore", "Dharmapuri", 
                "Dindigul", "Erode", "Kallakurichi", "Kanchipuram", "Kanyakumari", "Karur", 
                "Krishnagiri", "Madurai", "Mayiladuthurai", "Nagapattinam", "Namakkal", 
                "Nilgiris", "Perambalur", "Pudukkottai", "Ramanathapuram", "Ranipet", 
                "Salem", "Sivaganga", "Tenkasi", "Thanjavur", "Theni", "Thoothukudi", 
                "Tiruchirappalli", "Tirunelveli", "Tirupathur", "Tiruppur", "Tiruvallur", 
                "Tiruvannamalai", "Tiruvarur", "Vellore", "Viluppuram", "Virudhunagar"
            ],
            "Telangana" => [
                "Adilabad", "Bhadradri Kothagudem", "Hyderabad", "Jagtial", "Jangaon", 
                "Jayashankar Bhupalpally", "Jogulamba Gadwal", "Kamareddy", "Karimnagar", 
                "Khammam", "Kumuram Bheem Asifabad", "Mahabubabad", "Mahbubnagar", 
                "Mancherial", "Medak", "Medchal-Malkajgiri", "Mulugu", "Nagarkurnool", 
                "Nalgonda", "Narayanpet", "Nirmal", "Nizamabad", "Peddapalli", "Rajanna Sircilla", 
                "Ranga Reddy", "Sangareddy", "Siddipet", "Suryapet", "Vikarabad", "Wanaparthy", 
                "Warangal Rural", "Warangal Urban", "Yadadri Bhuvanagiri"
            ],
            "Tripura" => [
                "Dhalai", "Gomati", "Khowai", "North Tripura", "Sepahijala", "South Tripura", 
                "Unakoti", "West Tripura"
            ],
            "Uttar Pradesh" => [
                "Agra", "Aligarh", "Ambedkar Nagar", "Amethi", "Amroha", "Auraiya", "Ayodhya", 
                "Azamgarh", "Baghpat", "Bahraich", "Ballia", "Balrampur", "Banda", "Barabanki", 
                "Bareilly", "Basti", "Bhadohi", "Bijnor", "Budaun", "Bulandshahr", "Chandauli", 
                "Chitrakoot", "Deoria", "Etah", "Etawah", "Farrukhabad", "Fatehpur", "Firozabad", 
                "Gautam Buddha Nagar", "Ghaziabad", "Ghazipur", "Gonda", "Gorakhpur", "Hamirpur", 
                "Hapur", "Hardoi", "Hathras", "Jalaun", "Jaunpur", "Jhansi", "Kannauj", 
                "Kanpur Dehat", "Kanpur Nagar", "Kasganj", "Kaushambi", "Kheri", "Kushinagar", 
                "Lalitpur", "Lucknow", "Maharajganj", "Mahoba", "Mainpuri", "Mathura", "Mau", 
                "Meerut", "Mirzapur", "Moradabad", "Muzaffarnagar", "Pilibhit", "Pratapgarh", 
                "Prayagraj", "Raebareli", "Rampur", "Saharanpur", "Sambhal", "Sant Kabir Nagar", 
                "Shahjahanpur", "Shamli", "Shravasti", "Siddharthnagar", "Sitapur", "Sonbhadra", 
                "Sultanpur", "Unnao", "Varanasi"
            ],
            "Uttarakhand" => [
                "Almora", "Bageshwar", "Chamoli", "Champawat", "Dehradun", "Haridwar", 
                "Nainital", "Pauri Garhwal", "Pithoragarh", "Rudraprayag", "Tehri Garhwal", 
                "Udham Singh Nagar", "Uttarkashi"
            ],
            "West Bengal" => [
                "Alipurduar", "Bankura", "Birbhum", "Cooch Behar", "Dakshin Dinajpur", 
                "Darjeeling", "Hooghly", "Howrah", "Jalpaiguri", "Jhargram", "Kalimpong", 
                "Kolkata", "Malda", "Murshidabad", "Nadia", "North 24 Parganas", 
                "Paschim Bardhaman", "Paschim Medinipur", "Purba Bardhaman", "Purba Medinipur", 
                "Purulia", "South 24 Parganas", "Uttar Dinajpur"
            ],
            // Union Territories
            "Andaman and Nicobar Islands" => [
                "Nicobar", "North and Middle Andaman", "South Andaman"
            ],
            "Chandigarh" => [
                "Chandigarh"
            ],
            "Dadra and Nagar Haveli and Daman and Diu" => [
                "Dadra and Nagar Haveli", "Daman", "Diu"
            ],
            "Delhi" => [
                "Central Delhi", "East Delhi", "New Delhi", "North Delhi", "North East Delhi", 
                "North West Delhi", "Shahdara", "South Delhi", "South East Delhi", 
                "South West Delhi", "West Delhi"
            ],
            "Jammu and Kashmir" => [
                "Anantnag", "Bandipora", "Baramulla", "Budgam", "Doda", "Ganderbal", 
                "Jammu", "Kathua", "Kishtwar", "Kulgam", "Kupwara", "Poonch", "Pulwama", 
                "Rajouri", "Ramban", "Reasi", "Samba", "Shopian", "Srinagar", "Udhampur"
            ],
            "Ladakh" => [
                "Kargil", "Leh"
            ],
            "Lakshadweep" => [
                "Lakshadweep"
            ],
            "Puducherry" => [
                "Karaikal", "Mahe", "Puducherry", "Yanam"
            ]
        ];
    
        return view('applications.step2', compact('application', 'addresses', 'academics', 'stateDistrictData', 'advertisement'));
    }

    public function storeStep2(ApplicationStep2Request $request, Application $application)
    {
        $applicationId = $application->id;
        $application = Application::findOrFail($applicationId);
        // dd($application);

        try {
            $this->applicationService->saveStep2($applicationId, $request->validated());
            
            return redirect()->route('application.step3', $application)
                ->with('toastr', ['type' => 'success', 'message' => 'Step 2 completed!']);
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('toastr', ['type' => 'error', 'message' => 'Failed to save step 2']);
        }
    }
    // Step2 ends.

    public function step3(Application $application)
    {
        if ($application->student_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this application');
        }

        if ($application->status == 'submitted') {
            return redirect()->route('dashboard')
            ->with('toastr', ['type' => 'error', 'message' => 'Your application has already been submitted.']);
        }

        $applicationId = $application->id;
        $application = Application::findOrFail($applicationId);
        
        // $employment = $this->applicationService->employmentRepository->getByApplicationId($applicationId);
        // $enrollment = $this->applicationService->enrollmentRepository->getByApplicationId($applicationId);
        // $upscAttempts = $this->applicationService->upscRepository->getByApplicationId($applicationId);

        $employment = $this->applicationService->getEmploymentbyApplicationId($applicationId);
        // $enrollment = $this->applicationService->getEnrollmentbyApplicationId($applicationId);
        $enrollment = CurrentEnrollment::getEnrollmentbyApplicationId($applicationId);
        $upscAttempts = $this->applicationService->getUpscbyApplicationId($applicationId);

        // dd($enrollment);

        return view('applications.step3', compact('application', 'employment', 'enrollment', 'upscAttempts'));
    }

    public function storeStep3(ApplicationStep3Request $request, Application $application)
    {
        $applicationId = $application->id;
        $application = Application::findOrFail($applicationId);

        try {
            $data = $request->validated();
            
            $this->applicationService->saveEmploymentHistory($applicationId, $data['employment']);
            
            if ($data['enrollment']['course_name'] ?? false) {
                $this->applicationService->saveCurrentEnrollment($applicationId, $data['enrollment']);
            }
            
            if ($data['upsc_attempts'] ?? false) {
                $this->applicationService->manageUpscAttempts($applicationId, $data['upsc_attempts']);
            }

            return redirect()->route('application.step4', $application)
                ->with('toastr', ['type' => 'success', 'message' => 'Step 3 completed successfully']);
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('toastr', ['type' => 'error', 'message' => 'Failed to save: ' . $e->getMessage()]);
        }
    }

    public function getUpscAttemptTemplate(Request $request)
    {
        $index = $request->query('index', 0);
        return view('applications.partials.upsc_attempt', [
            'index' => $index,
            'attempt' => new UpscAttempt()
        ]);
    }
    // Step 3 ends

    public function step4(Application $application)
    {
        if ($application->student_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this application');
        }

        if ($application->status == 'submitted') {
            return redirect()->route('dashboard')
            ->with('toastr', ['type' => 'error', 'message' => 'Your application has already been submitted.']);
        }

        $applicationId = $application->id;
        $application = Application::findOrFail($applicationId);

        $application = Application::findOrFail($applicationId);
        $documents = $this->applicationService->getDocuments($applicationId);
        
        // Add verification status to view
        $verificationStatus = $documents->pluck('verification_status', 'type')->toArray();

        $profile = $application->profile()->where('id', $application->student_profile_id)->first();
        // dd($profile);
        
        return view('applications.step4', compact('application', 'documents', 'verificationStatus', 'profile'));
    }

    public function storeStep4(ApplicationStep4Request $request, Application $application)
    {
        $applicationId = $application->id;
        $application = Application::findOrFail($applicationId);
        try {
            $files = array_filter([
                'photo' => $request->file('photo'),
                'signature' => $request->file('signature'),
                'category_cert' => $request->file('category_cert'),
                'pwbd_cert' => $request->file('pwbd_cert'),
            ]);

            // Validate file sizes server-side
            $maxSizes = [
                'photo' => 2 * 1024 * 1024, // 2MB
                'signature' => 1 * 1024 * 1024, // 1MB
                'category_cert' => 5 * 1024 * 1024, // 5MB
                'pwbd_cert' => 5 * 1024 * 1024 // 5MB
            ];

            foreach ($files as $type => $file) {
                if ($file->getSize() > $maxSizes[$type]) {
                    return back()->withInput()->with('toastr', [
                        'type' => 'error',
                        'message' => "File size exceeds limit for {$type}"
                    ]);
                }
            }

            $this->applicationService->saveStep4($application, $files);

            return redirect()->route('application.step5', $application)
                ->with('toastr', ['type' => 'success', 'message' => 'Documents uploaded successfully!']);
        } catch (\Exception $e) {
            \Log::error('Document upload failed: ' . $e->getMessage());
            return back()->withInput()->with('toastr', [
                'type' => 'error',
                'message' => 'Failed to upload documents: ' . $e->getMessage()
            ]);
        }
    }

    // End Step 4
    public function step5(Application $application)
    {
        if ($application->student_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this application');
        }
        
        if ($application->status == 'submitted') {
            return redirect()->route('dashboard')
            ->with('toastr', ['type' => 'error', 'message' => 'Your application has already been submitted.']);
        }

        $applicationId = $application->id;
        $application = Application::findOrFail($applicationId);

        $details = $this->applicationService->getApplicationDetails($applicationId);
        return view('applications.step5', compact('details'));
    }

    public function submit(Request $request, Application $application)
    {
        if ($application->student_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this application');
        }
    
        $applicationId = $application->id;
        $application = Application::findOrFail($applicationId);
    
        try {
            \DB::beginTransaction();
    
            $application = $this->applicationService->submitApplication($applicationId);
    
            try {
                \Mail::to($application->profile->email)->send(new \App\Mail\ApplicationSubmitted($application));
            } catch (\Exception $emailException) {
                \Log::warning('Failed to send confirmation email: ' . $emailException->getMessage());
                // Continue with success even if email fails, but log the issue
            }
    
            \DB::commit();
    
            return redirect()->route('application.payment', $application)
                ->with('toastr', ['type' => 'success', 'message' => 'Application submitted successfully! Check your email for confirmation and download link.']);
        } catch (\Exception $e) {
            \DB::rollBack();
            
            \Log::error('Application submission failed: ' . $e->getMessage());
            return back()
                ->with('toastr', ['type' => 'error', 'message' => 'Failed to submit application: ' . $e->getMessage()]);
        }
    }

    // End Step 5 (Submit Application)


    // public function payment(Application $application)
    // {
    //     if ($application->student_id !== auth()->id()) {
    //         abort(403, 'Unauthorized access to this application');
    //     }

    //     $applicationId = $application->id;

    //     $application = Application::findOrFail($applicationId);
    //     $payment = $this->applicationService->getPaymentDetails($applicationId);

    //     $profile = $application->profile()->where('id', $application->student_profile_id)->first();
        
    //     // Assuming a fixed fee from advertisement_programs for simplicity
    //     // $fee = $application->advertisement->programs->first()->batch_program->fee ?? 1000;

    //     if($profile->category === 'SC' || $profile->category === 'ST'|| $profile->category === 'OBC'  || $profile->category === 'OBC A' || $profile->category === 'OBC B' || $profile->category === 'Reserved' ){
    //         $fee = 50;
    //     }else{
    //         $fee = 100;
    //     }

    //     return view('applications.payment', compact('application', 'payment', 'fee'));
    // }

    // public function storePayment(PaymentRequest $request, Application $application)
    // {
    //     $applicationId = $application->id;
    //     $application = Application::findOrFail($applicationId);

    //     try {
    //         $paymentData = $request->only(['amount', 'method', 'transaction_date', 'transaction_id']);
    //         $screenshot = $request->file('screenshot');

    //         $this->applicationService->processPayment($application, $paymentData, $screenshot);

    //         return redirect()->route('application.status', $application)
    //             ->with('toastr', ['type' => 'success', 'message' => 'Payment submitted successfully!']);
    //     } catch (\Exception $e) {
    //         return back()
    //             ->withInput()
    //             ->with('toastr', ['type' => 'error', 'message' => $e->getMessage()]);
    //     }
    // }

    // New added 20.03.2025

    public function payment(Application $application)
    {
        if ($application->student_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this application');
        }

        if ($application->payment_status === 'under review') {
            return redirect()->route('dashboard')
                ->with('toastr', ['type' => 'info', 'message' => 'You have already submitted your payment information.']);
        } elseif ($application->payment_status === 'paid') {
            return redirect()->route('dashboard')
                ->with('toastr', ['type' => 'success', 'message' => 'Your payment has been received.']);
        }

        $applicationId = $application->id;
        $application = Application::findOrFail($applicationId);
        $payment = $this->applicationService->getPaymentDetails($applicationId);

        $profile = $application->profile()->where('id', $application->student_profile_id)->first();
        
        $fee = in_array($profile->category, ['SC', 'ST', 'OBC', 'OBC A', 'OBC B', 'Reserved']) ? 50 : 100;

        return view('applications.payment', compact('application', 'payment', 'fee'));
    }

    public function storePayment(PaymentRequest $request, Application $application)
    {
        return $this->handlePayment($request, $application, 'store');
    }

    public function updatePayment(PaymentRequest $request, Application $application)
    {
        return $this->handlePayment($request, $application, 'update');
    }

    private function handlePayment(PaymentRequest $request, Application $application, string $action)
    {
        if ($application->student_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this application');
        }

        $applicationId = $application->id;
        $application = Application::findOrFail($applicationId);

        try {
            $paymentData = $request->only(['amount', 'method', 'transaction_date', 'transaction_id']);
            $screenshot = $request->file('screenshot');

            $this->applicationService->processPayment($application, $paymentData, $screenshot);

            $message = $action === 'store' 
                ? 'Payment submitted successfully!' 
                : 'Payment updated successfully!';

            return redirect()->route('application.status', $application)
                ->with('toastr', ['type' => 'success', 'message' => $message]);
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('toastr', ['type' => 'error', 'message' => $e->getMessage()]);
        }
    }

    // ./ End Payment Processing

    public function status(Application $application)
    {
        $applicationId = $application->id;
        $application = Application::findOrFail($applicationId);

        $application = Application::with([
            'advertisement',
            'profile',
            'payment',
            'payment.screenshot'
        ])->findOrFail($applicationId);

        if ($application->student_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this application');
        }

        $details = $this->applicationService->getApplicationDetails($applicationId);

        return view('applications.status', compact('application', 'details'));
    }

    // ./ End Application Status Checking

    public function download(Application $application)
    {
        $applicationId = $application->id;
        // $application = Application::findOrFail($applicationId);

        if ($application->student_id !== auth()->id()) {
            abort(403, 'Unauthorized access to this application');
        }
        
        try {
            $application = Application::with([
                'advertisement',
                'profile',
                'payment',
                'payment.screenshot'
            ])->findOrFail($applicationId);

            // if ($application->student_id !== auth()->id()) {
            //     abort(403, 'Unauthorized access to this application');
            // }

            $details = $this->applicationService->getApplicationDetails($applicationId);
            // $logoPath = public_path('images/logo.png');
            $logoPath = 'images/logo.png';
            // dd($logoPath);

            // Prepare image data with fallback
            $photo = $details['documents']->where('type', 'photo')->first();
            $signature = $details['documents']->where('type', 'signature')->first();

            $photo_base64 = $this->processImage($photo?->file_path, 150, 150);
            $signature_base64 = $this->processImage($signature?->file_path, 200, 80);
            // $photo_base64 = $this->processImage($photo?->file_path, 100, 100); // Reduced from 150x150
            // $signature_base64 = $this->processImage($signature?->file_path, 150, 60); // Reduced from 200x80
            $logo_base64 = $this->processImage($logoPath, 200, 200, false);

            $data = [
                'application' => $application,
                'details' => $details,
                'photo_base64' => $photo_base64,
                'signature_base64' => $signature_base64,
                'logo_base64' => $logo_base64,
                'institute_name' => 'Satyendra Nath Tagore Civil Services Study Centre',
                'institute_type' => 'Government of West Bengal',
                'institute_address' => 'NSATI Campus, FC Block, Sector-III, Salt Lake, Kolkata-700106'
            ];

            $pdf = PDF::loadView('applications.pdf', $data)
                ->setPaper('a4', 'portrait')
                ->setOptions([
                    'defaultFont' => 'DejaVu Sans',
                    'isHtml5ParserEnabled' => true,
                    'isRemoteEnabled' => true,
                    'dpi' => 96 // Optimize for faster rendering
                ]);

            return $pdf->download('application_' . $application->application_number . '.pdf');
            // return $pdf->stream();
        } catch (\Exception $e) {
            Log::error('PDF generation failed: ' . $e->getMessage());
            abort(500, 'Unable to generate PDF. Please try again later.');
        }
    }

    private function processImage(?string $filePath, int $maxWidth, int $maxHeight, bool $useStorage = true): ?string
    {
        try {
            // Resolve full path based on storage type
            // $fullPath = $useStorage && $filePath 
            //     ? Storage::path($filePath) 
            //     : $filePath;

            $fullPath = storage_path('app/public/' . $filePath);

                // \URL::to(Storage::disk()->url($filePath))

            if (!$fullPath || !file_exists($fullPath)) {
                Log::warning("Image not found at path: {$fullPath}");
                return null;
            }

            $image = @imagecreatefromstring(file_get_contents($fullPath));
            if ($image === false) {
                Log::warning("Failed to create image from: {$fullPath}");
                return null;
            }

            // Get original dimensions
            $width = imagesx($image);
            $height = imagesy($image);

            // Calculate new dimensions maintaining aspect ratio
            $ratio = min($maxWidth / $width, $maxHeight / $height);
            $newWidth = max(1, (int)($width * $ratio));  // Ensure minimum 1px
            $newHeight = max(1, (int)($height * $ratio));

            // Create optimized image
            $optimized = imagecreatetruecolor($newWidth, $newHeight);
            
            // Preserve transparency for PNG
            imagealphablending($optimized, false);
            imagesavealpha($optimized, true);

            imagecopyresampled(
                $optimized, 
                $image, 
                0, 0, 0, 0, 
                $newWidth, 
                $newHeight, 
                $width, 
                $height
            );

            // Output to buffer
            ob_start();
            imagejpeg($optimized, null, 75); // 75% quality
            $data = ob_get_clean();

            // Clean up
            imagedestroy($image);
            imagedestroy($optimized);

            return base64_encode($data);
        } catch (\Exception $e) {
            Log::error("Image processing failed for {$filePath}: " . $e->getMessage());
            return null;
        }
    }

}