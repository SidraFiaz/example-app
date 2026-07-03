<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Result') }}
        </h2>
    </x-slot>

    <div class="py-12">
         
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="flex items-center gap-4 justify-end p-6">

                    <a href="{{ route('student.create') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">
                    <x-primary-button>{{ __('Add new Student') }}</x-primary-button></a>
                    

                </div>
        
   
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
    <table class="w-4/5 mx-auto border border-gray-400 border-collapse text-center">
        <thead>
    <tr class="bg-gray-200">
        <th class="border border-gray-400 px-4 py-2">ID</th>
        <th class="border border-gray-400 px-4 py-2">Name</th>
        <th class="border border-gray-400 px-4 py-2">Email</th>
        <th class="border border-gray-400 px-4 py-2">Age</th>
        <th class="border border-gray-400 px-4 py-2">Gender</th>
        <th class="border border-gray-400 px-4 py-2">Actions</th>
    </tr>
</thead>
    

        <tbody>
    @foreach($students as $student)
    <tr>
    <td class="border border-gray-400 px-4 py-2 text-center">{{ $loop->iteration }}</td>

    <td class="border border-gray-400 px-4 py-2">{{ $student->name }}</td>
    <td class="border border-gray-400 px-4 py-2">{{ $student->email }}</td>
    <td class="border border-gray-400 px-4 py-2">{{ $student->age }}</td>
    <td class="border border-gray-400 px-4 py-2">{{ $student->gender }}</td>

        
       
<td class="border border-gray-400 px-4 py-2">
               <a href="{{ route('student.edit', $student->id) }}">
    <x-primary-button>Edit</x-primary-button>
</a>


      <x-danger-button
    x-data=""
    x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion-{{ $student->id }}')">
    Delete Student
</x-danger-button>



     <x-modal name="confirm-user-deletion-{{ $student->id }}" focusable>
        <form method="post" action="{{ route('profile.destroy', $student->id) }}" class="p-6">
            @csrf
            @method('delete')

            <h2 class="text-lg font-medium text-gray-900">
                {{ __('Are you sure you want to delete this student?') }}
            </h2>



            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Cancel') }}
                </x-secondary-button>

                <x-danger-button class="ms-3">
                    {{ __('delete') }}
                </x-danger-button>
            </div>
            </div>
</form>
            

      
</x-modal>
        </td>
    </tr>
    @endforeach
</tbody>
    </table>
            </div>
            
        </div>
    </div>



</x-app-layout>