<x-app-layout>

    <x-slot name="header">
        <div>
            <h2 class="text-2xl font-semibold text-gray-900">
                Edit Fee Type
            </h2>
            <div class="flex items-center gap-2 text-sm mt-1">
                <a href="{{ route('dashboard') }}" class="text-gray-700 hover:text-black">
                    Home
                </a>
                <span class="text-gray-400">/</span>
                <span class="text-gray-500">Edit</span>
            </div>
        </div>
    </x-slot>

    <div class="py-6 bg-gray-50 min-h-[calc(100vh-8rem)]">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="bg-white rounded-2xl shadow-[0_1px_8px_rgba(0,0,0,0.06)] p-6 sm:p-10">

                @if ($errors->any())
                    <div class="mb-6 px-4 py-3 rounded-md bg-red-100 text-red-700 text-sm">
                        <ul class="list-disc ml-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form
                    action="{{ route('fee-types.update', $fee_type) }}"
                    method="POST"
                >
                    @csrf
                    @method('PUT')

                    <div class="ft-edit-field">
                        <label for="fee_name" class="block text-sm font-medium text-gray-700 mb-2">
                            Fee Type Description <span class="text-red-500">*</span>
                        </label>

                        <input
                            type="text"
                            id="fee_name"
                            name="fee_name"
                            value="{{ old('fee_name', $fee_type->fee_name) }}"
                            class="ft-edit-input"
                            required
                        >

                        @error('fee_name')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="ft-edit-actions">
                        <a href="{{ route('fee-types.index') }}" class="ft-edit-cancel">
                            Cancel
                        </a>
                        <button type="submit" class="ft-edit-save">
                            Save
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <style>
        .ft-edit-field {
            margin: 0 0 28px 0;
            padding: 0;
        }

        .ft-edit-input {
            display: block;
            width: 100%;
            height: 44px;
            box-sizing: border-box;
            border: 1px solid #d1d5db;
            border-radius: 8px;
            background: #ffffff;
            color: #374151;
            font-size: 14px;
            padding: 0 12px;
            margin: 0;
            position: static;
            transform: none;
        }

        .ft-edit-input:focus {
            outline: none;
            border-color: #9ca3af;
        }

        .ft-edit-actions {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-wrap: wrap;
            gap: 12px;
            margin: 0;
            padding: 0;
            position: static;
            transform: none;
        }

        .ft-edit-cancel {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 96px;
            height: 40px;
            padding: 0 20px;
            border-radius: 8px;
            background: #e5e7eb;
            color: #374151;
            font-size: 14px;
            font-weight: 500;
            text-decoration: none;
            margin: 0;
            position: static;
            transform: none;
        }

        .ft-edit-cancel:hover {
            background: #d1d5db;
        }

        .ft-edit-save {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 96px;
            height: 40px;
            padding: 0 20px;
            border: 0;
            border-radius: 8px;
            background: #111827;
            color: #ffffff;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            margin: 0;
            position: static;
            transform: none;
        }

        .ft-edit-save:hover {
            background: #1f2937;
        }
    </style>

</x-app-layout>
