<div class="card">
    <div class="card-header">
        <h2>Shared Accounts</h2>
    </div>

    <div class="card-body">
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">Name</th>
                <th scope="col">Balance</th>
                <th scope="col">Owner</th>
                <th scope="col">Access</th>
                <th scope="col"></th>
                <th scope="col"></th>
            </tr>
            </thead>
            <tbody>
            @foreach($contasPartilhadas as $infoConta)
            <tr>
                <td> {{ $infoConta->nome}} </td>
                <td> {{ $infoConta->saldo_atual}} </td>
                {{--{{dd($infoConta)}}--}}
                <td> {{ $infoConta->user->name}} </td>
                <td>
                    @if($infoConta->pivot->so_leitura == 1)
                        Read
                    @else
                        Complete
                    @endif
                </td>

                <td>
                    <a  class="btn btn-primary" href="{{ route('sharedAccountDetails', ['conta' => $infoConta,'user'=>$infoConta->pivot->user_id])}}" >
                        Details
                    </a>
                </td>
                @if ($infoConta->pivot->so_leitura == 0)
                    <td>
                        <a  class="btn btn-dark" href="{{route('viewUpdateAccount',['user'=>$infoConta->pivot->user_id,'conta'=>$infoConta])}}" >
                            Update
                        </a>
                    </td>
                @endif
            </tr>
            @endforeach
            </tbody>
        </table>
        </div>
    </div>
