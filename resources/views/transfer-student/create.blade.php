<x-app-layout>

<x-slot name="header">
    <h2 class="font-semibold text-xl text-gray-800">
        Transfer Student
    </h2>
</x-slot>


<div class="py-6">

<div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

<div class="bg-white p-6 rounded shadow">


<h2 class="text-xl font-bold mb-6">
    Transfer Student
</h2>


<form action="{{ route('admission.transfer.store',$admission->id) }}" method="POST">

@csrf



<!-- Branch -->

<div class="mb-4">

<label class="block mb-2 font-medium">
Transfer To
</label>

<select name="branch_id"
class="w-full border rounded p-3"
required>

<option value="">
Select Branch
</option>

@foreach($branches as $branch)

<option value="{{ $branch->id }}">
{{ $branch->name }}
</option>

@endforeach

</select>

</div>




<!-- Class -->

<div class="mb-4">

<label class="block mb-2 font-medium">
To Class
</label>


<select 
name="class_id"
id="class_id"
class="w-full border rounded p-3"
required>


<option value="">
Select Class
</option>


@foreach($classes as $class)

<option value="{{ $class->id }}">
{{ $class->class_name }}
</option>

@endforeach


</select>

</div>




<!-- Section -->


<div class="mb-4">

<label class="block mb-2 font-medium">
Section
</label>


<select 
name="section_id"
id="section_id"
class="w-full border rounded p-3"
required>


<option value="">
Select Section
</option>


</select>


</div>





<div class="flex justify-end gap-3 mt-6">


<a href="{{ route('admission.index') }}"
class="bg-gray-500 text-white px-5 py-2 rounded">

Close

</a>



<button type="submit"
class="bg-blue-600 text-white px-5 py-2 rounded">

Save

</button>


</div>



</form>


</div>

</div>

</div>



<script>


document.getElementById('class_id')
.addEventListener('change', function(){


let class_id = this.value;


let section = document.getElementById('section_id');



section.innerHTML =
`
<option>
Loading...
</option>
`;



fetch('/get-sections/' + class_id)


.then(response => response.json())


.then(data => {


section.innerHTML =
`
<option value="">
Select Section
</option>
`;



data.forEach(function(item){


section.innerHTML +=

`
<option value="${item.id}">
${item.section_name}
</option>
`;


});


});



});



</script>


</x-app-layout>