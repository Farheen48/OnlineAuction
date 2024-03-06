@php
$name = session()->get('name');
$path = session()->get('path');
if($path === 'Admin'){
    $count_pending_seller_req =  App\Models\User::where([
    ['path','=','Seller'],
    ['status','=','Pending']
    ])->count();
}elseif($path === 'User'){
    $serial = session()->get('serial');
    if(DB::table('balences')->where('serial','=',$serial)->exists() === true){
        $balence = DB::table('balences')->where('serial','=',$serial)->value('balance');
    }else{
        $balence = 0;
    }
}else{
    $balence = 0;
}
$mock_ip_status= App\Models\MockIP::where('index','=','status')->value('value');
@endphp
<div class="col-sm-10 col-md-7 col-lg-4">
    <div class="dashboard-widget mb-30 mb-lg-0">
        <div class="user">
            <div class="content">
                <h5 class="title"><a href="#0">{{ $name }}</a></h5>
                <span class="username">[{{ $path }}]</span>
            </div>
        </div>
        <ul class="dashboard-menu">
            <li>
                @if($path === 'Admin')
                <a href="{{ route('admin.dashboard') }}" class="active">Dashboard</a>
                @elseif($path === 'User')
                <a href="{{ route('user.dashboard') }}" class="active">Dashboard</a>
                @elseif($path === 'Seller')
                <a href="{{ route('seller.dashboard') }}" class="active">Dashboard</a>
                @endif
            </li>
            @if($path === 'Admin')
            <li>
                <a href="{{ route('seller.list') }}">
                    <button type="button" class="btn position-relative">
                        Seller Request
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-success text-md">
                            {{ $count_pending_seller_req }}
                        </span>
                    </button>
                </a>
            </li>
            <li>
                <a href="{{ route('view.category_list') }}" class=" text-center">
                   Add Category
                </a>
            </li>
            <li>
                <div class="card">
                    <div class="card-body">
                        <div class="p-2">
                            <p class="bg-primary text-white m-2 text-center">Mock IP: {{ $mock_ip_status }}</p>
                            <form action="{{ route('update.mocklocation') }}" method="post">
                                @csrf
                               <div class="mb-3">
                                <select class="form-select" aria-label="Default select example" id="moc_ip" name="moc_ip">
                                    <option value="on">Turn On</option>
                                    <option value="off">Turn off</option>
                                </select>
                               </div>
                               <div class="mb-3">
                                <button class="btn btn-primary btn-sm">Set</button>
                               </div>
                            </form>
                        </div>
                    </div>
                </div>
            </li>
            @elseif($path === 'User')
            <li>
                <a href="{{ route('add.balance') }}">Add Balence <span class="p-1 text-center bg-primary" >[{{ $balence }} BDT]</span></a>
                <br>
                <p>Bidding exprences: {{ App\Models\Balence::where('serial','=',session()->get('serial'))->value('bitting_expence') }}</p>
            </li>
            @elseif($path === 'Seller')
            <li>
                <a href="{{ route('product_reg.lit_seller') }}">Register Product</a>
                <a href="{{ route('registered.product') }}">ViewRegistered Product</a>
            </li>
            @endif
        </ul>
    </div>
</div>
