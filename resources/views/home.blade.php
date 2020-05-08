
@extends('layouts.app')
@section('content')
<div class="container-fluid">
    @if(session()->get('message'))
        <div class="alert alert-success" role="alert">
            <a href="#" class="close" data-dismiss="alert" arial-label="close">&times;</a>
            <strong>SUCCESS:</strong>&nbsp;{{session()->get('message')}}
        </div>
    @endif
    <div class="row">
        <div class="col-sm-4" >

            <img src="{{Auth::user()->foto != null ? asset('storage/fotos/' . Auth::user()->foto) : asset('storage/fotos/user_default.png')}}" class="rounded-circle" width="250" height="250">

            <form method="POST" action="{{ route('home')  }}" enctype="multipart/form-data">
                @csrf
                <div class="form-group row">
                    <div class="col-md-6">
                        <input id="foto" type="file" class="form-control @error('foto') is-invalid @enderror" name="foto">

                        @error('foto')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror

                        <button type="submit" class="btn btn-success">
                            {{ __('Save Photo') }}
                        </button>

                    </div>
                </div>
            </form>
            <h4>{{Auth::user()->name}}</h4>
            <h4>{{Auth::user()->email}}</h4>
            <h4>Phone Number: {{Auth::user()->telefone}}</h4>
            <h4>NIF: {{Auth::user()->NIF}}</h4>
        </div>
        <div class="col-sm-8 " >
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sit amet vulputate lacus, ut interdum augue. Nullam quis mi vel massa volutpat molestie vel tristique arcu. Maecenas non dolor tristique libero aliquam porttitor. In et tincidunt velit. Maecenas libero nunc, mollis tincidunt nisl eget, lobortis accumsan nulla. Aenean at ligula ac massa facilisis tristique. Cras cursus diam vel suscipit molestie.

                Aenean semper, elit sit amet hendrerit placerat, purus tellus mollis risus, vitae iaculis dui quam a tortor. Sed maximus lorem at turpis pretium posuere non quis ex. Praesent vulputate felis velit, ac luctus risus consectetur eu. Curabitur nec finibus ligula, id blandit turpis. Interdum et malesuada fames ac ante ipsum primis in faucibus. Nulla eleifend condimentum arcu, at maximus turpis aliquam ac. Sed elementum egestas rhoncus. Suspendisse potenti. Cras turpis purus, aliquam nec felis a, egestas vehicula ante. Vestibulum egestas id odio nec laoreet. Nullam sem nisi, condimentum et nulla in, cursus luctus diam. Etiam suscipit nisi ac libero finibus, ac vestibulum quam aliquet.

                Nullam fringilla orci eget sollicitudin vehicula. Maecenas non lacus non nibh tristique euismod. Praesent aliquet tellus ut sollicitudin hendrerit. Nullam sit amet auctor lorem. Aliquam sodales eleifend purus in varius. Cras non eros nec libero laoreet varius ac suscipit felis. Aliquam tristique consequat mauris in ullamcorper. Nunc ipsum quam, dictum eu varius nec, sodales sed nunc. Nam posuere vestibulum lacus vitae consequat. Fusce urna ante, ornare vel est sit amet, sagittis cursus leo. Proin mollis ex ac lacus eleifend, in interdum dui auctor.

                Donec interdum justo at ex vulputate, nec tincidunt lacus imperdiet. Nulla facilisi. Fusce ornare, mi vitae viverra ultricies, eros elit posuere nisi, non placerat quam leo ut sapien. Duis odio diam, iaculis vel blandit ut, euismod ut mi. Nunc tristique auctor gravida. Vivamus ullamcorper a tellus ut sollicitudin. Donec ac justo nec urna viverra sagittis a at ante. Nam dapibus, nulla sit amet facilisis fermentum, turpis mauris elementum justo, id scelerisque mauris magna nec turpis.

                Etiam ut pellentesque velit. Nullam non dolor vitae lectus sodales hendrerit. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia curae; Nullam a ligula cursus, interdum nunc eu, sollicitudin quam. Duis ultrices rutrum turpis, sit amet suscipit neque. Vestibulum sagittis urna ut odio congue, facilisis dictum felis interdum. Phasellus ac gravida massa. Morbi sodales pulvinar volutpat.</p>
        </div>
    </div>
</div>
@endsection
