@extends('layouts.app')

@section('content')
    <div class="flex h-screen justify-center items-center">
        <div class="w-96 border-gray-400 shadow-md p-6 rounded-md"> <!-- THIS DIV WILL BE CENTERED -->
            <h2 class="font-bold text-center p-2 mb-2">Author's Details</h2>
            <form action="/authors" method="post">
            @csrf

            <!-- Name Form Input -->
                <div class="mb-6">
                    <label
                        class="block mb-2 uppercase font-bold text-xs text-gray-700"
                        for="name"
                    >
                        Name:
                    </label>

                    <input
                        class="border border-gray-400 rounded-sm p-2 w-full @error('name') border-red-500 @enderror"
                        type="text"
                        name="name"
                        id="name"
                        required
                    >

                    @error('name')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Dob Form Input -->
                <div class="mb-6">
                    <label
                        class="block mb-2 uppercase font-bold text-xs text-gray-700"
                        for="dob"
                    >
                        Dob:
                    </label>

                    <input
                        class="border border-gray-400 rounded-sm p-2 w-full @error('name') border-red-500 @enderror"
                        type="text"
                        name="dob"
                        id="dob"
                        required
                    >

                    @error('dob')
                    <p class="text-red-500 text-xs mt-2">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex justify-between">
                    <a href="#"
                       class="bg-gray-400 text-white rounded py-2 px-4 hover:bg-gray-500"
                    >Cancel</a>
                    <button
                        class="bg-blue-400 text-white rounded py-2 px-4 hover:bg-blue-500"
                        type="submit"
                    >
                        Submit
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
