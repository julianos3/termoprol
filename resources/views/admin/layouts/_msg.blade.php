@if($errors->any())
    <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
        @foreach($errors->all() as $error)
            {{ $error }}<br />
        @endforeach
    </div>
@endif

@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
    </div>
@endif

@if(isset($warnings))
    <?php $cont = 0; ?>
    @foreach($warnings as $warning)
        <?php $cont++ ?>
        {!! $warning !!}
    @endforeach
@endif