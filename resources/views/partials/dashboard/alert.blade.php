@session('status')
    <div class="alert alert-success">
        <div class="flex items-start space-x-3 rtl:space-x-reverse">
            <div class="flex-1">
                {{ session('status') }}
            </div>
        </div>
    </div>
@endsession
