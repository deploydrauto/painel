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


    @include('modals.clientes_user')

    @include('modals.client_add')

    @include('modals.user_add')

    @include('modals.user_edit')






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
                showModal('xl-modal')
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
