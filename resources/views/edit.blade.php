<div class="text-center mt-5">
    <h2>Edit info</h2>
</div>

<form  method="POST" action="{{route('edit',['info'=>$info->id])}}">

    @csrf

    {{ method_field('PUT') }}

    <div class="row justify-content-center mt-5">

        <div class="col-lg-6">
            <div class="mb-3">
                <label class="form-label">Website</label>
                <input type="text" class="form-control" name="website" placeholder="Title" value="{{$info->website}}">
            </div>
            <div class="mb-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" name="email" placeholder="Email" value="{{$info->email}}">
            </div>
            <div class="mb-3">
                <label class="form-label">Password</label>
                <input type="text" class="form-control" name="password" placeholder="Password" value="{{$info->password}}">
            </div>

            <div class="mb-3">
                <button type="submit" class="btn btn-primary">Submit</button>
            </div>
    </div>

</form>
