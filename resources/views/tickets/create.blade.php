@extends('layouts.app')
@section('content')
    @include('layouts.menu')
    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="border-bottom mb-3 pt-3 pb-2">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                <h1 class="h2">{{$event->name}}</h1>
            </div>
            <span class="h6">{{date('F j, Y',strtotime($event->date))}}</span>
        </div>

        <div class="mb-3 pt-3 pb-2">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                <h2 class="h4">Create new ticket</h2>
            </div>
        </div>

        <form method="post" class="needs-validation" novalidate action="{{route('tickets.store',$event)}}">

            <div class="row">
                <div class="col-12 col-lg-4 mb-3">
                    <label for="inputName">Name</label>
                    <!-- adding the class is-invalid to the input, shows the invalid feedback below -->
                    <input type="text" class="form-control {{$errors->has('name')?'is-invalid':''}}" id="inputName"
                           name="name" placeholder="" value="{{old('name')}}">
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{$errors->first('name')}}
                        </div>
                    @endif

                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-4 mb-3">
                    <label for="inputCost">Cost</label>
                    <input type="number" class="form-control {{$errors->has('cost')?'is-invalid':''}}" id="inputCost"
                           name="cost" placeholder="" value="{{old('cost')??0}}">
                    @if($errors->has('cost'))
                        <div class="invalid-feedback">
                            {{$errors->first('cost')}}
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-4 mb-3">
                    <label for="selectSpecialValidity">Special Validity</label>
                    <select class="form-control {{$errors->has('special_validity')?'is-invalid':''}}"
                            id="selectSpecialValidity"
                            name="special_validity">
                        <option value="">None</option>
                        <option {{old('special_validity') == 'amount'?'selected':''}} value="amount">Limited amount
                        </option>
                        <option {{old('special_validity') == 'date'?'selected':''}}  value="date">Purchaseable till
                            date
                        </option>
                    </select>
                    @if($errors->has('special_validity'))
                        <div class="invalid-feedback">
                            {{$errors->first('special_validity')}}
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-4 mb-3">
                    <label for="inputAmount">Maximum amount of tickets to be sold</label>
                    <input type="number" class="form-control {{$errors->has('amount')?'is-invalid':''}}" id="inputAmount"
                           name="amount" placeholder="" value="{{old('amount')??0}}">
                    @if($errors->has('amount'))
                        <div class="invalid-feedback">
                            {{$errors->first('amount')}}
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-4 mb-3">
                    <label for="inputValidTill">Tickets can be sold until</label>
                    <input type="text"
                           class="form-control {{$errors->has('date')?'is-invalid':''}}"
                           id="inputValidTill"
                           name="date"
                           placeholder="yyyy-mm-dd HH:MM"
                           value="{{old('date')}}">
                    @if($errors->has('date'))
                        <div class="invalid-feedback">
                            {{$errors->first('date')}}
                        </div>
                    @endif
                </div>
            </div>

            <hr class="mb-4">
            <button class="btn btn-primary" type="submit">Save ticket</button>
            <a href="{{route('events.show',$event)}}" class="btn btn-link">Cancel</a>
            @csrf
        </form>

    </main>
@endsection
