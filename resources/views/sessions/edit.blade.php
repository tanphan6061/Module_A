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
                <h2 class="h4">Edit session</h2>
            </div>
        </div>

        <form method="post" class="needs-validation" novalidate action="{{route('sessions.update',[$event,$session])}}">
            @method('put')
            <div class="row">
                <div class="col-12 col-lg-4 mb-3">
                    <label for="selectType">Type</label>
                    <select class="form-control {{$errors->has('type')?'is-invalid':''}}" id="selectType" name="type">
                        <option value="talk" {{old('type')=='talk'||$session->type=='talk'?'selected':''}}>Talk
                        </option>
                        <option value="workshop" {{old('type')=='workshop'||$session->type=='workshop'?'selected':''}}>
                            Workshop
                        </option>
                    </select>
                    @if($errors->has('type'))
                        <div class="invalid-feedback">
                            {{$errors->first('type')}}
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-4 mb-3">
                    <label for="inputTitle">Title</label>
                    <!-- adding the class is-invalid to the input, shows the invalid feedback below -->
                    <input type="text" class="form-control {{$errors->has('title')?'is-invalid':''}}" id="inputTitle"
                           name="title" placeholder="" value="{{old('title')??$session->title}}">
                    @if($errors->has('title'))
                        <div class="invalid-feedback">
                            {{$errors->first('title')}}
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-4 mb-3">
                    <label for="inputSpeaker">Speaker</label>
                    <input type="text" class="form-control {{$errors->has('speaker')?'is-invalid':''}}"
                           id="inputSpeaker"
                           name="speaker" placeholder="" value="{{old('speaker')??$session->speaker}}">
                    @if($errors->has('speaker'))
                        <div class="invalid-feedback">
                            {{$errors->first('speaker')}}
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-4 mb-3">
                    <label for="selectRoom">Room</label>
                    <select class="form-control {{$errors->has('room_id')?'is-invalid':''}}" id="selectRoom"
                            name="room_id">
                        @foreach($event->rooms as $room)
                            <option
                                value="{{$room->id}}" {{old('room_id')==$room->id|| $session->room_id == $room->id ?'selected':''}}>{{$room->name}}
                                / {{$room->channel->name}}</option>
                        @endforeach
                    </select>
                    @if($errors->has('room_id'))
                        <div class="invalid-feedback">
                            {{$errors->first('room_id')}}
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-4 mb-3">
                    <label for="inputCost">Cost</label>
                    <input type="number" class="form-control {{$errors->has('cost')?'is-invalid':''}}" id="inputCost"
                           name="cost" placeholder="" value="{{old('cost')??intval($session->cost)}}">
                    @if($errors->has('cost'))
                        <div class="invalid-feedback">
                            {{$errors->first('cost')}}
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-12 col-lg-6 mb-3">
                    <label for="inputStart">Start</label>
                    <input type="text"
                           class="form-control {{$errors->has('start')?'is-invalid':''}}"
                           id="inputStart"
                           name="start"
                           placeholder="yyyy-mm-dd HH:MM"
                           value="{{old('start')??date('Y-m-d H:i',strtotime($session->start))}}">
                    @if($errors->has('start'))
                        <div class="invalid-feedback">
                            {{$errors->first('start')}}
                        </div>
                    @endif
                </div>
                <div class="col-12 col-lg-6 mb-3">
                    <label for="inputEnd">End</label>
                    <input type="text"
                           class="form-control {{$errors->has('end')?'is-invalid':''}}"
                           id="inputEnd"
                           name="end"
                           placeholder="yyyy-mm-dd HH:MM"
                           value="{{old('end')??date('Y-m-d H:i',strtotime($session->end))}}">
                    @if($errors->has('end'))
                        <div class="invalid-feedback">
                            {{$errors->first('end')}}
                        </div>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="col-12 mb-3">
                    <label for="textareaDescription">Description</label>
                    <textarea class="form-control {{$errors->has('description')?'is-invalid':''}}"
                              id="textareaDescription"
                              name="description" placeholder=""
                              rows="5">{{old('description')??$session->description}}</textarea>
                    @if($errors->has('description'))
                        <div class="invalid-feedback">
                            {{$errors->first('description')}}
                        </div>
                    @endif
                </div>
            </div>

            <hr class="mb-4">
            <button class="btn btn-primary" type="submit">Save session</button>
            <a href="{{route('events.show',$event)}}" class="btn btn-link">Cancel</a>
            @csrf
        </form>

    </main>
@endsection
