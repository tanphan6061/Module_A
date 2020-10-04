@extends('layouts.app')
@section('content')
    @include('layouts.menu')

    <main role="main" class="col-md-9 ml-sm-auto col-lg-10 px-4">
        <div class="border-bottom mb-3 pt-3 pb-2">
            <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
                <h1 class="h2">{{$event->name}}</h1>
            </div>
        </div>

        <form method="post" class="needs-validation" novalidate action="{{route('events.update',$event)}}">
            @method('put')
            <div class="row">
                <div class="col-12 col-lg-4 mb-3">
                    <label for="inputName">Name</label>
                    <!-- adding the class is-invalid to the input, shows the invalid feedback below -->
                    <input name="name" type="text" class="form-control {{$errors->has('name')?'is-invalid':''}}" id="inputName"
                           placeholder="" value="{{old('name')??$event->name}}">
                    @if($errors->has('name'))
                        <div class="invalid-feedback">
                            {{$errors->first('name')}}
                        </div>
                    @endif

                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-4 mb-3">
                    <label for="inputSlug">Slug</label>
                    <input name="slug" type="text" class="form-control {{$errors->has('slug')?'is-invalid':''}}" id="inputSlug"
                           placeholder="" value="{{old('slug')??$event->slug}}">
                    @if($errors->has('slug'))
                        <div class="invalid-feedback">
                            {{$errors->first('slug')}}
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-4 mb-3">
                    <label for="inputDate">Date</label>
                    <input name="date" type="text"
                           class="form-control {{$errors->has('date')?'is-invalid':''}}"
                           id="inputDate"
                           placeholder="yyyy-mm-dd"
                           value="{{old('date')??$event->date}}">
                    @if($errors->has('date'))
                        <div class="invalid-feedback">
                            {{$errors->first('date')}}
                        </div>
                    @endif
                </div>
            </div>

            <hr class="mb-4">
            <button class="btn btn-primary" type="submit">Save</button>
            <a href="{{route('events.show',$event)}}" class="btn btn-link">Cancel</a>
            @csrf
        </form>

    </main>
@endsection
