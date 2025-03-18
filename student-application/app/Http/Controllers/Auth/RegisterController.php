<?php

// app/Http/Controllers/Auth/RegisterController.php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRegistrationRequest;
use App\Http\Requests\RegisterRequest;
use App\Domain\Services\StudentService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegistrationSuccess; // We'll create this Mailable

class RegisterController extends Controller
{
    private $studentService;

    public function __construct(StudentService $studentService)
    {
        $this->studentService = $studentService;
        // $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        $indiaStatesDistricts = [
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

        return view('auth.register',  compact('indiaStatesDistricts'));
    }

    public function register(RegisterRequest $request) //StudentRegistrationRequest
    {
        // dd($request);
        try {
            $student = $this->studentService->register($request->validated());
            
            // Auth::loginUsingId($student->id);
            // Auth::guard('student')->login($student);
            Auth::guard('web')->login($student);
            $request->session()->regenerate();

            // Store temporary registration data in session
            $request->session()->put('show_welcome', true);
            $credentials = [
                'email' => $request->email,
                'password' => $request->password // Plain password before hashing
            ];
            $request->session()->put('registration_credentials', $credentials);

            // Send registration success email
            Mail::to($student->email)->send(new RegistrationSuccess($student, $credentials['password']));


            \Log::info('Login successful for: ' . $student->first_name);
            
            // return redirect()->route('dashboard')
            //     ->with('toastr', ['type' => 'success', 'message' => 'Registration successful!']);
            return redirect()->route('welcome');
        } catch (\Exception $e) {
            // return back()
            //     ->withInput()
            //     ->with('toastr', ['type' => 'error', 'message' => 'Registration failed!']);

            return redirect()->back()
            ->withInput()
            ->with('toastr', [
                'type' => 'error',
                'message' => 'Registration failed: ' . $e->getMessage()
            ]);
        }
    }

    // Add these new validation methods
    public function validateSecondaryRoll(Request $request)
    {
        $exists = Student::where('secondary_roll', $request->value)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function validateEmail(Request $request)
    {
        $exists = Student::where('email', $request->value)->exists();
        return response()->json(['exists' => $exists]);
    }

    public function validateMobile(Request $request)
    {
        $exists = Student::where('mobile', $request->value)->exists();
        return response()->json(['exists' => $exists]);
    }


    public function showWelcome(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        if (!$request->session()->has('show_welcome')) {
            return redirect()->route('dashboard');
        }

        $credentials = $request->session()->get('registration_credentials');
        
        return view('auth.welcome', [
            'email' => $credentials['email'],
            'password' => $credentials['password']
        ]);
    }

    public function proceedToDashboard(Request $request)
    {
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // Clear the welcome flag and credentials from session
        $request->session()->forget(['show_welcome', 'registration_credentials']);
        
        return redirect()->route('dashboard')
            ->with('toastr', ['type' => 'success', 'message' => 'Welcome to your dashboard!']);
    }
}