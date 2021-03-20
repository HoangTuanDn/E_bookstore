<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">

            </div>
            <div class="col-sm-6 float-right ">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                    @if($module)
                        <li class="breadcrumb-item"><a href="{{route($module.'.index')}}">{{$module}}</a></li>
                    @endif
                    @if(isset($action))
                        <li class="breadcrumb-item active">{{$action}}</li>
                    @endif
                </ol>
            </div>
        </div>
    </div><!-- /.container-fluid -->
</section>