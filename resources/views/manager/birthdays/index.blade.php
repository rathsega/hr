@extends('index')
@push('title', get_phrase('Birthdays'))
@push('meta')
@endpush
@push('css')
@endpush

@section('content')

    <div class="mainSection-title">
        <div class="d-flex justify-content-between align-items-center flex-wrap gr-15">
            <div class="d-flex flex-column">
                <h4>{{ get_phrase('Birthdays') }}</h4>
            <ul class="d-flex align-items-center eBreadcrumb-2">
                    <li><a href="#">{{ get_phrase('Dashboard') }}</a></li>
                    <li><a href="#">{{ get_phrase('Birthdays') }}</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="eSection-wrap">
                <div class="row">
                    
                    <div class="col-lg-9 col-md-9">
                    <p class="column-title mb-2">{{get_phrase('Birthdays')}}</p>
                    </div>
                
                    <div class="col-lg-3 col-md-3 justify-content-end">
                    <input type="text" id="search" class="rounded" placeholder="Search...">
                    </div>
                </div>
                <div class="table-responsive">
                    <table class="table eTable">
                        <thead>
                            <tr>
                                <th class="">#</th>
                                <th class="">{{ get_phrase('Name') }}</th>
                                <th class="">{{ get_phrase('Date') }}</th>
                            </tr>
                        </thead>
                        <tbody id="table-body">
                            @foreach (App\Models\User::orderBy('birthday')->get() as $key => $birthdays)
                                <tr>
                                    <td>
                                        {{ ++$key }}
                                    </td>
                                    <td>
                                        {{ $birthdays->name }}
                                    </td>
                                    <td>
                                        {{ $birthdays->birthday ? date('jS M', strtotime($birthdays->birthday)) : '' }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Sample data
        const data = <?php echo App\Models\User::orderBy('birthday')->get(); ?>;
        const tableBody = document.getElementById('table-body');
        const searchInput = document.getElementById('search');

        // Initial data rendering
        renderData(data);

        // Event listener for search input
        searchInput.addEventListener('input', function () {
            const query = this.value.trim().toLowerCase();
            const filteredData = filterData(data, query);
            renderData(filteredData);
        });

        // Function to filter data based on the search query
        function filterData(data, query) {
            if (!query) {
                return data;
            }

            data = data.filter(row =>{
                let formattedDate;
                if(row.birthday){
                    const dateObject = new Date(row.birthday);

                    // Extract individual date components
                    const month = dateObject.getMonth() + 1; // Adding 1 because months are zero-based
                    const day = dateObject.getDate();
                    const year = dateObject.getFullYear();

                    // Create the formatted date string in "M-D-Y" format
                    formattedDate = `${day}-${month}-${year}`;
                }else{
                    formattedDate = null;
                }
                
            return (row.name ? row.name.toLowerCase().includes(query) : row.name) ||
                (formattedDate ? formattedDate.toLowerCase().includes(query) : formattedDate)
            });
            return data;
        }

        // Function to render data in the table
        function renderData(data) {
            tableBody.innerHTML = '';

            data.forEach((row, key) => {
                const tr = document.createElement('tr');
                const date = new Date(row.birthday);
                const options = { day: 'numeric', month: 'short' };
                const formattedDate = date.toLocaleDateString('en-US', options);
                tr.innerHTML = `
                    <td>${++key}</td>
                    <td>${row.name}</td>
                    <td>${formattedDate}</td>
                `;
                tableBody.appendChild(tr);
            });
        }
    });
</script>