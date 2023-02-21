<x-template-layout>
    <div class="col-md-12 mb-md-5 mb-xl-10">
        <div class="card">
            <div class="card-body py-4 mt-1  text-center">
                <h1>Welcome {{ Auth::user()->name }}</h1>
            </div>
        </div>
    </div>
</x-template-layout>