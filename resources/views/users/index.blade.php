<x-app-layout>
    <style>
        .accordion {
            background-color: #eee;
            color: #444;
            cursor: pointer;
            padding: 18px;
            width: 100%;
            border: none;
            text-align: left;
            outline: none;
            font-size: 15px;
            transition: 0.4s;

        }

        .active,
        .accordion:hover {
            background-color: #ccc;
        }

        .panel {
            padding: 0 18px;
            display: none;
            background-color: white;
        }

        .modal {
            transition: opacity 0.25s ease;
        }

        body.modal-active {
            overflow-x: hidden;
            overflow-y: visible !important;
        }
    </style>
    <x-slot name="header">
        <div class="flex justify-end">
            <x-primary-button  data-bs-toggle="modal" data-bs-target="#user_add_modal" >{{ __('+ Adicionar') }}
            </x-primary-button>
        </div>

    </x-slot>

    <div class="max-w-2xl mx-auto">

        <div class="flex flex-col">
            <div class="overflow-x-auto shadow-md sm:rounded-lg">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden ">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                        Usuario
                                    </th>
                                    <th scope="col"
                                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                        email
                                    </th>
                                    <th scope="col"
                                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                        Statistic
                                    </th>


                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700">
                                @foreach ($users as $user)
                                    <tr class="hover:bg-gray-100 dark:hover:bg-gray-700 cursor-pointer">
                                        <td onClick="editUser({{ $user->id }})"
                                            class="py-4 px-6 text-sm font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            {{ $user->name }}
                                        </td>
                                        <td onClick="editUser({{ $user->id }})"
                                            class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">
                                            {{ $user->email }}
                                        </td>
                                        <td
                                            class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">
                                            <p>
                                                <x-primary-button  data-bs-toggle="modal" data-bs-target="#exampleModalXl" onClick="fetchUserClients({{ $user->id }})"
                                                    class="mt-1">Clientes: {{ $user->clientes }}
                                                </x-primary-button>
                                            </p>
                                            <p>
                                                <x-primary-button class="mt-1"  data-bs-toggle="modal" data-bs-target="#users_games"> Games : {{ $user->games }}
                                                </x-primary-button>
                                            </p>
                                            <p>
                                                <x-primary-button class="mt-1"> WebHooks : {{ $user->webhooks }}
                                                </x-primary-button>
                                            </p>

                                        </td>

                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>


    </div>

    @include('modals.user_add');
    @include('modals.clientes_user');
    @include('modals.games_user');




    {{-- <x-bladewind.modal name="user-create" title="Cadastrar Novo" size="big" id="" ok_button_label=""
        cancel_button_label="">
        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                    :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                    :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">


                <x-primary-button class="ml-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </x-bladewind.modal> --}}

    {{-- <x-bladewind.modal name="user-edit" title="Editar Usuario" size="big" id="" ok_button_label=""
        cancel_button_label="">
        <form id="user-edit-form" method="POST" action="{{ route('users.edit', [$user->id]) }}">
            @csrf

            <!-- Name -->
            <div>
                <x-input-label for="name" :value="__('Name')" />
                <x-text-input id="name" class="block mt-1 w-full" type="text" name="name"
                    :value="old('name')" required autofocus />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email Address -->
            <div class="mt-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                    :value="old('email')" required />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-input-label for="password" :value="__('Password')" />

                <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required
                    autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirm Password -->
            <div class="mt-4">
                <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

                <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password"
                    name="password_confirmation" required />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>

            <div class="flex items-center justify-end mt-4">


                <x-primary-button class="ml-4">
                    {{ __('Register') }}
                </x-primary-button>
            </div>
        </form>
    </x-bladewind.modal> --}}

</x-app-layout>

<script>
    function loadModal() {
        // showModal('user_add')
        console.log(document.querySelectorAll('user_add'))

    }
    // replace action of form
    function editUser(id) {
        var form = document.getElementById('user-edit-form');
        fetch('/users/show/' + id)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                form.name.value = data.name;
                form.email.value = data.email;
                form.password.value = data.password;
                form.password_confirmation.value = data.password_confirmation;
            });
        form.action = '/users/edit/' + id;


        showModal('user-edit')
    }

    function storeClient() {

        let form = document.getElementById('client-form');


        let formData = new FormData();
        formData.body
        let url = '/client/new';
        let method = 'POST';
        let data = {
            _token: '{{ csrf_token() }}',
            method: method,
            body: formData
        }
        fetch(url, data)
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.status == 'success') {
                    alert('Cliente cadastrado com sucesso');
                    form.reset();
                    // hideModal('client');
                }
            });
    }

    // store client with json in /client/new post method
    function storeClientJson() {

        let form = document.getElementById('client-form');

        $.ajax({
            url: "{{ route('client.store') }}",
            type: "POST",
            async: false,
            data: {
                _token: $('[name=_token]').val(),
                id_user: form.user_id.value,
                body: {
                    _token: '{{ csrf_token() }}',
                    nome: form.nome.value,
                    email: form.email.value,
                    telefone: form.telefone.value,
                    client_inicio: form.client_inicio.value,
                    id_user: form.user_id.value,
                    id_game: form.games_select.value,
                    id_plan: form.plans_select.value,
                },
            },
            success: function(data) {
                fetchUserClients(form.user_id.value);
                alert('Cliente cadastrado com sucesso');
                form.reset();
                hideModal('client');
            }
        });

    }

    function fetchUserClients(id) {

        fetch('/users/clientes/' + id)
            .then(response => response.json())
            .then(data => {
                document.getElementById('user_id').value = id;
                let table = document.getElementById('user-clients-table');
                table.innerHTML = '';
                data.forEach(client => {
                    let row = document.createElement('tr');
                    row.innerHTML = `
                        <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white"><p>Nome: ${client.nome}</p> <p>Email: ${client.email}</p> <p>Telefone: ${client.telefone}</p></td>
                        <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white"><p>Ativação:${client.data_atv}</p>
                                                                                                                    <p>Meio:${client.meio}</p>
                                                                                                                    <p>Inicio:${client.inicio}</p>
                                                                                                                    <p>Fim:${client.termino}</p></td>

                        <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">${client.name}</td>
                        <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white"><button id >${client.id}</button></td>

                    `;
                    table.appendChild(row);
                });
            });
    }
</script>
