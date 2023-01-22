@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            <div class="card">

                <div class="card-header">{{ __('Dashboard') }}</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    {{ __('You are logged in!') }}
                </div>
                <div class="col row-cols-auto">
                    <div class="row-cols-auto">
                        @if(session()->has('success'))
                            <div class="alert alert-success">
                                {{ session()->get('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger">
                                    {{$error}}
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="text-center mt-3">
                    <h2>Add Info</h2>

                    <form class="row g-3" method="POST" action="{{route('store')}}">
                        @csrf
                        <div class="col-4">
                            <input type="text" class="form-control" name="website" placeholder="Website">
                        </div>
                        <div class="col-3">
                            <input type="text" class="form-control" name="email" placeholder="Email">
                        </div>
                        <div class="col-3">
                            <input type="text" class="form-control" name="password" placeholder="Password">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary mb-3">Add</button>
                        </div>
                    </form>
                </div>

                <table class="table">
                    <thead>
                        <tr>
                            <th>Website</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Strength</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($infos as $info)
                        @auth
                            <tr>
                            <th>{{$info->website}}</th>
                            <th> {{$info->email}} </th>
                            <td>{{ substr($info->password, 0, 1) . '*********'}}</td>
                            <td>
                                @if($info->is_strong == true)
                                    <div class="badge bg-success">Strong</div>
                                @else
                                    <div class="badge bg-warning">Weak</div>
                                @endif
                            </td>
                            <td>
                                <a href="{{route('view',['info'=>$info->id])}}" class="btn btn-light">view</a>
                                <a href="{{route('edit',['info'=>$info->id])}}" class="btn btn-info">Edit</a>
                                <a href="{{route('destroy',['info'=>$info->id])}}" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                        @endauth
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
