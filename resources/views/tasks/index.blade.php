<x-app-layout>

<div class="max-w-5xl mx-auto p-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-800">Tasks</h2>

        <button onclick="openModal()"
            class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700">
            + Add Task
        </button>
    </div>
    <form method="GET" class="mb-6">
        <select name="project_id"
            onchange="this.form.submit()"
            class="border border-gray-300 rounded-lg px-3 py-2 w-60">

            <option value="">All Projects</option>

            @foreach($projects as $project)
                <option value="{{$project->id}}"
                    {{$projectId==$project->id ? 'selected':''}}>
                    {{$project->name}}
                </option>
            @endforeach
        </select>
    </form>  
    <div class="bg-white rounded-xl shadow overflow-hidden">
       
        <div class="grid grid-cols-3 bg-gray-100 px-4 py-3 font-semibold text-gray-700">
            <div>Task Name</div>
            <div>Project</div>
            <div class="text-right">Actions</div>
        </div>


        <ul id="taskList">

            @forelse($tasks as $task)

            <li data-id="{{$task->id}}"
                class="grid grid-cols-3 items-center border-t px-4 py-3 hover:bg-gray-50">
               
                <div>                 
                    <div id="view-{{$task->id}}">
                        {{$loop->iteration}}. {{$task->name}}
                    </div>                   
                    <form id="edit-{{$task->id}}"
                        method="POST"
                        action="{{route('tasks.update',$task)}}"
                        class="hidden flex gap-2">

                        @csrf
                        @method('PUT')

                        <input name="name"
                            value="{{$task->name}}"
                            class="border rounded px-2 py-1 text-sm w-full">

                        <button class="bg-yellow-500 text-white px-3 py-1 rounded text-sm">
                            Save
                        </button>

                        <button type="button"
                            onclick="cancelEdit({{$task->id}})"
                            class="bg-gray-400 text-white px-3 py-1 rounded text-sm">
                            Cancel
                        </button>

                    </form>
                </div>

               
                <div class="text-gray-600">
                    {{$task->project->name ?? '-'}}
                </div>

                
                <div id="actions-{{$task->id}}" class="flex justify-end gap-2">

                    <button onclick="showEdit({{$task->id}})"
                        class="bg-blue-500 text-white px-3 py-1 rounded text-sm">
                        Edit
                    </button>

                    <form method="POST" action="{{route('tasks.destroy',$task)}}">
                        @csrf
                        @method('DELETE')

                        <button
                            class="bg-red-500 text-white px-3 py-1 rounded text-sm">
                            Delete
                        </button>
                    </form>

                </div>

            </li>

            @empty
                <p class="p-4 text-gray-500">No tasks found</p>
            @endforelse

        </ul>

    </div>

</div>

<div id="taskModal"
    class="fixed inset-0 bg-black/30 hidden items-center justify-center z-50">

    <div class="bg-white w-96 p-6 rounded-xl shadow-2xl">

        <div class="flex justify-between mb-4">
            <h3 class="text-lg font-semibold">Add Task</h3>

            <button onclick="closeModal()">✕</button>
        </div>

        <form method="POST" action="{{route('tasks.store')}}">
            @csrf

            <input name="name"
                placeholder="Task name"
                required
                class="border w-full rounded px-3 py-2 mb-3">

            <select name="project_id"
                required
                class="border w-full rounded px-3 py-2 mb-4">

                @foreach($projects as $project)
                    <option value="{{$project->id}}">
                        {{$project->name}}
                    </option>
                @endforeach
            </select>

            <button class="w-full bg-blue-600 text-white py-2 rounded-lg">
                Save Task
            </button>

        </form>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>

<script>

function refreshListingNumbers(){

document.querySelectorAll('#taskList li').forEach((item,index)=>{

    let viewDiv = item.querySelector('[id^="view-"]');

    if(viewDiv){

        let text = viewDiv.innerText.split('. ').slice(1).join('. ');
        viewDiv.innerText = (index+1)+'. '+text;

    }
});

}
new Sortable(taskList,{
    animation:150,

    onEnd:function(){

        refreshListingNumbers();

let order = [];

document.querySelectorAll('#taskList li').forEach(item=>{
    order.push(item.dataset.id);
});

fetch("{{route('tasks.reorder')}}",{
    method:'POST',
    headers:{
        'Content-Type':'application/json',
        'X-CSRF-TOKEN': '{{csrf_token()}}'
    },
    body: JSON.stringify({order})
});


    }
});


function openModal(){
    document.getElementById('taskModal').classList.remove('hidden');
    document.getElementById('taskModal').classList.add('flex');
}

function closeModal(){
    document.getElementById('taskModal').classList.add('hidden');
}


function showEdit(id){
    document.getElementById('view-'+id).classList.add('hidden');
    document.getElementById('actions-'+id).classList.add('hidden');
    document.getElementById('edit-'+id).classList.remove('hidden');
}

function cancelEdit(id){
    document.getElementById('view-'+id).classList.remove('hidden');
    document.getElementById('actions-'+id).classList.remove('hidden');
    document.getElementById('edit-'+id).classList.add('hidden');
}

</script>

</x-app-layout>
