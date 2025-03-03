<div>
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h3>Расписание занятий</h3>
        <button wire:click="generateSchedule" class="btn btn-primary">Сгенерировать заново</button>
    </div>
    <div class="row mb-3">
        <div class="col-md-4">
            <label for="selectedDay">Выберите день</label>
            <select wire:model.lazy="selectedDay" class="form-control">
                <option value="">Все дни</option>
                @foreach($days as $day)
                    <option value="{{ $day->id }}">{{ $day->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label for="selectedClass">Выберите класс</label>
            <select wire:model.lazy="selectedClass" class="form-control">
                <option value="">Все классы</option>
                @foreach($classes as $class)
                    <option value="{{ $class->id }}">{{ $class->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-4">
            <label for="selectedTeacher">Выберите учителя</label>
            <select wire:model.lazy.lazy="selectedTeacher" class="form-control">
                <option value="">Все учителя</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->id }}">{{ $teacher->name }}</option>
                @endforeach
            </select>
        </div>
    </div>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>День</th>
            <th>Время</th>
            <th>Класс</th>
            <th>Предмет</th>
            <th>Учитель</th>
        </tr>
        </thead>
        <tbody>
        @foreach($schedule as $lesson)
            <tr>
                <td>{{ $lesson->day->name }}</td>
                <td>{{ $lesson->bell->start_time }} - {{ $lesson->bell->end_time }}</td>
                <td>{{ $lesson->class->name }}</td>
                <td>{{ $lesson->subject->name }}</td>
                <td>{{ $lesson->teacher->name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
