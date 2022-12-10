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
            <x-primary-button onclick="showModal('user-create')">{{ __('+ Adicionar') }}
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
                                                <x-primary-button onClick="fetchUserClients({{ $user->id }})"
                                                    class="mt-1">Clientes: {{ $user->clientes }}
                                                </x-primary-button>
                                            </p>
                                            <p>
                                                <x-primary-button class="mt-1"> Games : {{ $user->games }}
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



    <x-bladewind.modal size="xl" title="Clientes do Usuario" name="xl-modal">
        <div id="modal_content">


            <button class="modal-open bg-transparent border border-gray-500 hover:border-indigo-500 text-gray-500 hover:text-indigo-500 font-bold py-2 px-4 rounded-full">Cadastrar Novo Us</button>

            <div class="panel">


        </div>
        <br>
        <br>
        <div class="flex flex-col">
            <div class="overflow-x-auto shadow-md sm:rounded-lg">
                <div class="inline-block min-w-full align-middle">
                    <div class="overflow-hidden ">
                        <table class="min-w-full divide-y divide-gray-200 table-fixed dark:divide-gray-700">
                            <thead class="bg-gray-100 dark:bg-gray-700">
                                <tr>
                                    <th scope="col"
                                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                        Cliente
                                    </th>
                                    <th scope="col"
                                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                        email
                                    </th>
                                    <th scope="col"
                                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                        Telefone
                                    </th>
                                    <th scope="col"
                                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                        Jogos
                                    </th>
                                    <th scope="col"
                                        class="py-3 px-6 text-xs font-medium tracking-wider text-left text-gray-700 uppercase dark:text-gray-400">
                                        Actions
                                    </th>
                                    </th>

                                <tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200 dark:bg-gray-800 dark:divide-gray-700"
                                id="user-clients-table">
                            </tbody>
                        </table>
                    </div>
                </div>




            </div>
    </x-bladewind.modal>


    <!--Modal-->
    <div class="modal opacity-0 pointer-events-none fixed w-full h-full top-0 left-0 flex items-center justify-center" id="modal_client">
      <div class="modal-overlay absolute w-full h-full bg-gray-900 opacity-50"></div>

      <div class="modal-container bg-white w-11/12 md:max-w-md mx-auto rounded shadow-lg z-50 overflow-y-auto">

        <div class="modal-close absolute top-0 right-0 cursor-pointer flex flex-col items-center mt-4 mr-4 text-white text-sm z-50">
          <svg class="fill-current text-white" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
            <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
          </svg>
          <span class="text-sm">(Esc)</span>
        </div>

        <!-- Add margin if you want to see some of the overlay behind the modal-->
        <div class="modal-content py-4 text-left px-6">
          <!--Title-->
          <div class="flex justify-between items-center pb-3">
            <p class="text-2xl font-bold">Simple Modal!</p>
            <div class="modal-close cursor-pointer z-50">
              <svg class="fill-current text-black" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18">
                <path d="M14.53 4.53l-1.06-1.06L9 7.94 4.53 3.47 3.47 4.53 7.94 9l-4.47 4.47 1.06 1.06L9 10.06l4.47 4.47 1.06-1.06L10.06 9z"></path>
              </svg>
            </div>
          </div>

          <form method="POST" class="client-form" id="client-form">
            @csrf

                <div class="flex flex-wrap">
                    <input type="hidden" name="user_id" id="user_id" value="0">
                    <x-bladewind.input name="nome" id="client_nome" required="true" label="nome" />
                    <x-bladewind.input name="email" id="client_email" required="true" label="email" />
                </div>
                    <x-bladewind.input name="telefone" id="client_telefone" required="true" label="telefone" />
                    <x-bladewind.datepicker name="client_inicio" id="client_inicio" required="true"
                    label="inicio" />

                    <x-bladewind.dropdown name="games_select" id="games_select" placeholder="Selecione um BOT"
                        data="{{ json_encode($games) }}" />
                    <x-bladewind.dropdown name="plans_select" id="plans_select" placeholder="Selecione um plano"
                        data="{{ json_encode($plans) }}" />

                    <p><x-bladewind.checkbox checked="true" label="Ativo?" /></p>

    <br>
    <br>

    </form>
          <!--Footer-->
          <div class="flex justify-end pt-2">
            <button class="modal-close px-4 bg-transparent p-3 rounded-lg text-indigo-500 hover:bg-gray-100 hover:text-indigo-400 mr-2">Cancelar</button>
            <button class="  px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400 modal-close"  onCLick="storeClientJson()" >Cadastrar</button>
          </div>

        </div>
      </div>
    </div>
    <x-bladewind.modal name="user-create" title="Cadastrar Novo" size="big" id="" ok_button_label=""
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
    </x-bladewind.modal>

    <x-bladewind.modal name="user-edit" title="Editar Usuario" size="big" id="" ok_button_label=""
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
    </x-bladewind.modal>

</x-app-layout>
<script>
    let modal = document.getElementById("modal");

    function modalHandler(val) {
        if (val) {
            fadeIn(modal);
        } else {
            fadeOut(modal);
        }
    }

    function fadeOut(el) {
        el.style.opacity = 1;
        (function fade() {
            if ((el.style.opacity -= 0.1) < 0) {
                el.style.display = "none";
            } else {
                requestAnimationFrame(fade);
            }
        })();
    }

    function fadeIn(el, display) {
        el.style.opacity = 0;
        el.style.display = display || "flex";
        (function fade() {
            let val = parseFloat(el.style.opacity);
            if (!((val += 0.2) > 1)) {
                el.style.opacity = val;
                requestAnimationFrame(fade);
            }
        })();
    }
</script>
<script>
    // display modal
    function fetchGames(id) {

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
        // let form = document.getElementById('client-form');
        // let url = '/client/new';
        // let method = 'POST';
        // // pass token in header

        // let data = {
        //     _token: '{{ csrf_token() }}',
        //     token: '{{ csrf_token() }}',
        //     method: method,
        //     body: JSON.stringify({
        //         _token: '{{ csrf_token() }}',
        //         nome: form.nome.value,
        //         email: form.email.value,
        //         telefone: form.telefone.value,
        //         client_inicio: form.client_inicio.value,
        //         id_user: form.user_id.value,
        //         id_game: form.games_select.value,
        //         id_plan: form.plans_select.value,




        //     }),
        //     headers: {
        //         'Content-Type': 'application/json'
        //     }
        // }
        // fetch(url, data)
        //     .then(response => response.json())
        //     .then(data => {
        //         console.log(data);
        //         if (data.status == 'success') {
        //             alert('Cliente cadastrado com sucesso');
        //             form.reset();
        //             // hideModal('client');
        //         }
        //     });
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

                        <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">${client.status}</td>
                        <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white">${client.name}</td>
                        <td class="py-4 px-6 text-sm font-medium text-gray-500 whitespace-nowrap dark:text-white"><button id >${client.id}</button></td>

                    `;
                    table.appendChild(row);
                });
                showModal('xl-modal')
            });
    }
</script>
<script>
    var acc = document.getElementsByClassName("accordion");
    var i;

    for (i = 0; i < acc.length; i++) {
        acc[i].addEventListener("click", function() {
            this.classList.toggle("active");
            var panel = this.nextElementSibling;
            if (panel.style.display === "block") {
                panel.style.display = "none";
            } else {
                panel.style.display = "block";
            }
        });
    }
</script>
<script>
    var openmodal = document.querySelectorAll('.modal-open')
    for (var i = 0; i < openmodal.length; i++) {
      openmodal[i].addEventListener('click', function(event){
    	event.preventDefault()
    	toggleModal()
      })
    }

    const overlay = document.querySelector('.modal-overlay')
    overlay.addEventListener('click', toggleModal)

    var closemodal = document.querySelectorAll('.modal-close')
    for (var i = 0; i < closemodal.length; i++) {
      closemodal[i].addEventListener('click', toggleModal)
    }

    document.onkeydown = function(evt) {
      evt = evt || window.event
      var isEscape = false
      if ("key" in evt) {
    	isEscape = (evt.key === "Escape" || evt.key === "Esc")
      } else {
    	isEscape = (evt.keyCode === 27)
      }
      if (isEscape && document.body.classList.contains('modal-active')) {
    	toggleModal()
      }
    };


    function toggleModal () {
      const body = document.querySelector('body')
      const modal = document.querySelector('.modal')
      modal.classList.toggle('opacity-0')
      modal.classList.toggle('pointer-events-none')
      body.classList.toggle('modal-active')
    }


  </script>
