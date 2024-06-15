

    <a href="{{ route('notifications') }}" class="">

        <div class="bg-primary rounded-circle position-fixed d-flex justify-content-center align-items-center" style="height: 50px;width: 50px;left: 50px;bottom: 40px;z-index: 10000;">
            <span class="text-white h4 m-0 p-0"><i class="fas fa-bell"></i></span>
            <span class="position-absolute top-0 start-100 translate-middle badge border border-light rounded-circle bg-danger p-2">
                {{ count(get_notifications()) }}
            </span>
        </div>

    </a>
