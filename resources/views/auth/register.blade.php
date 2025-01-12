<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <div>
            <x-input-label for="first_name" :value="__('First Name')" />
            <x-text-input id="first_name" class="block mt-1 w-full" type="text" name="first_name" value="{{ old('first_name') }}" required autofocus />
            <x-input-error :messages="$errors->get('first_name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="last_name" :value="__('Last Name')" />
            <x-text-input id="last_name" class="block mt-1 w-full" type="text" name="last_name" value="{{ old('last_name') }}" required />
            <x-input-error :messages="$errors->get('last_name')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" value="{{ old('email') }}" required />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
            <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required />
            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="role" :value="__('Role')" />
            <select id="role" name="role" class="block mt-1 w-full" required>
                <option></option>
                <option value="patient" {{ old('role') == 'patient' ? 'selected' : '' }}>Patient</option>
                <option value="doctor" {{ old('role') == 'doctor' ? 'selected' : '' }}>Doctor</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
            </select>
        </div>

        <!--doctor fields-->
        <div id="doctorFields"  style="display:none;">
            <div>
                <x-input-label for="specialization" :value="__('Specialization')" />
                <x-text-input id="specialization" class="block mt-1 w-full" type="text" name="specialization" value="{{ old('specialization') }}" />
                <x-input-error :messages="$errors->get('specialization')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="license_number" :value="__('License Number')" />
                <x-text-input id="license_number" class="block mt-1 w-full" type="text" name="license_number" value="{{ old('license_number') }}" />
                <x-input-error :messages="$errors->get('license_number')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="doctor_phone_number" :value="__('Phone Number')" />
                <x-text-input id="doctor_phone_number" class="block mt-1 w-full" type="text" name="doctor_phone_number" value="{{ old('doctor_phone_number') }}" />
                <x-input-error :messages="$errors->get('doctor_phone_number')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="experience_years" :value="__('Experience Years')" />
                <x-text-input id="experience_years" class="block mt-1 w-full" type="number" name="experience_years" value="{{ old('experience_years') }}" />
                <x-input-error :messages="$errors->get('experience_years')" class="mt-2" />
            </div>
        </div>

        <!--patient fields-->
        <div id="patientFields"  style="display:none;">
            <div>
                <x-input-label for="patient_phone_number" :value="__('Phone Number')" />
                <x-text-input id="patient_phone_number" class="block mt-1 w-full" type="text" name="patient_phone_number" value="{{ old('patient_phone_number') }}" />
                <x-input-error :messages="$errors->get('patient_phone_number')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="address" :value="__('Address')" />
                <x-text-input id="address" class="block mt-1 w-full" type="text" name="address" value="{{ old('address') }}" />
                <x-input-error :messages="$errors->get('address')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="dob" :value="__('Date of Birth')" />
                <x-text-input id="dob" class="block mt-1 w-full" type="date" name="dob" value="{{ old('dob') }}" />
                <x-input-error :messages="$errors->get('dob')" class="mt-2" />
            </div>

            <div>
                <x-input-label for="gender" :value="__('Gender')" />
                <select id="gender" name="gender" class="block mt-1 w-full">
                    <option></option>
                    <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                </select>
                <x-input-error :messages="$errors->get('gender')" class="mt-2" />
            </div>



        </div>


        <div class="flex items-center justify-end mt-4">
            <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('login') }}">
                {{ __('Already registered?') }}
            </a>

            <x-primary-button class="ms-4">
                {{ __('Register') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

<script>
    document.getElementById('role').addEventListener('change', function() {
        var role = this.value;
        if (role == 'doctor') {
            document.getElementById('doctorFields').style.display = 'block';
            document.getElementById('patientFields').style.display = 'none';
        } else if (role == 'patient') {
            document.getElementById('doctorFields').style.display = 'none';
            document.getElementById('patientFields').style.display = 'block';
        } else {
            document.getElementById('doctorFields').style.display = 'none';
            document.getElementById('patientFields').style.display = 'none';
        }
    });
</script>


