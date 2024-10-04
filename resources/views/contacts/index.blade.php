<x-layout>
    <div class="container">
        <h2>All Messages</h2>

        <table class="table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Message</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($queries as $query)
                    <tr>
                        <td>{{ $query->name }}</td>
                        <td>{{ $query->email }}</td>
                        <td>{{ $query->message }}</td>
                        <td>{{ $query->created_at->format('d M, Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layout>
