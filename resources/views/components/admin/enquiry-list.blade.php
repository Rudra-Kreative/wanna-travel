@props(['enquiries' => $enquiries])

<table id="enquiries_table" class="display" data-target="">
    <thead>
        <tr>
            <th>Name</th>
            <th>Subject</th>
            <th>Email</th>
            <th>Message</th>
            <th>Reply</th>
        </tr>
    </thead>
    <tbody id="enquiries_body">
        @foreach ($enquiries as $enquery)
            <tr>
                <td>
                    <p>{{ $enquery->fname . ' ' . $enquery->lname }}</p>
                </td>
                <td>{{ $enquery->subject ?? '' }}</td>
                <td><a href="mailto:{{ $enquery->email ?? '' }}">{{ $enquery->email ?? '' }}</a></td>
                <td style="font-size: 15px;
                text-align: justify;
                line-height: 22px;">
                    {{ $enquery->query ?? '' }}</td>

                <td data-enqueryId="{{ $enquery->id }}">
                    <a href="mailto:{{ $enquery->email ?? '' }}"><i class="fas fa-reply reply" title="Reply"   style="cursor: pointer;" aria-hidden="true"></i></a>
                </td>
            </tr>
        @endforeach
    </tbody>
</table>
