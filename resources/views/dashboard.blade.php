<x-app-layout>
    <x-slot name="header">
        <h1 class="font-semibold text-xl text-gray-800 leading-tight">
            Управлять моими мероприятиями
        </h1>
    </x-slot>

    <style>
        table th:not(:last-child) {
            background-color: floralwhite;
            font-size: 18px;
        }
        table tr td:not(:last-child), tr th:not(:last-child) {
            border: 1px solid black;
            text-align: left;
            padding: 5px 10px;
        }
        table tr td:last-child {
            padding-left: 20px;
        }
        table tr td:last-child label:hover {
            cursor: pointer;
        }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">

                    @if (isset($eventsForUser[0]))
                    <p class="text-lg text-gray-800">Вы записались на следующие мероприятия:</p>
                    <div class="table-entries">
                        <table>
                        <tr><th>название</th><th>дата</th><th>описание</th><th></th></tr>
                        @foreach ($eventsForUser as $n)
                            <tr>
                                <td>{{ $n->name }}</td>
                                <td>{{ date('j F, H:i', strtotime($n->date)) }}</td>
                                <td>
                                @if (mb_strlen( $n->description ) > 160)
                                    {{ mb_substr($n->description, 0, 157, 'utf-8') }}...
                                @else
                                    {{ $n->description }}
                                @endif
                                </td>
                                <td>
                                    <form style="display:none" action="/dashboard/{{ $n->id }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('DELETE') }}
                                        <button id="event_{{ $n->id }}" type="submit" name="action" value=""></button>
                                    </form>
                                    <label for="event_{{ $n->id }}">Отписаться</label>
                                </td>
                            </tr>
                        @endforeach
                        </table>
                        <br>
                    </div>
                    @else
                        <p class="text-lg text-gray-800 mb-4">Вы пока не записались ни на одно мероприятие!</p>
                    @endif

                    @if (isset($eventsNotForUser[0]))
                    <p class="text-lg text-gray-800">Мероприятия, на которые вы всё ещё не записаны:</p>
                    <div class="table-entries">
                        <table>
                        <tr><th>название</th><th>дата</th><th>описание</th><th></th></tr>
                        @foreach ($eventsNotForUser as $n)
                            <tr>
                                <td>{{ $n->name }}</td>
                                <td>{{ date('j F, H:i', strtotime($n->date)) }}</td>
                                <td>
                                @if (mb_strlen( $n->description ) > 160)
                                    {{ mb_substr($n->description, 0, 157, 'utf-8') }}...
                                @else
                                    {{ $n->description }}
                                @endif
                                </td>
                                <td>
                                    <form style="display:none" action="/dashboard/{{ $n->id }}" method="POST">
                                        {{ csrf_field() }}
                                        {{ method_field('PUT') }} <!-- GET, HEAD, PUT, PATCH, DELETE -->
                                        <button id="event_{{ $n->id }}" type="submit" name="action" value=""></button>
                                    </form>
                                    <label for="event_{{ $n->id }}">Записаться</label>
                                </td>
                            </tr>
                        @endforeach
                        </table>
                        <br>
                    </div>
                    @else
                        <p class="text-lg text-gray-800 mb-4">Вы записаны на все мероприятия!</p>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
