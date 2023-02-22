<div class="offcanvas offcanvas-start fixed bottom-0 flex flex-col max-w-full bg-white invisible bg-clip-padding shadow-sm outline-none transition duration-300 ease-in-out text-gray-700 top-0 left-0 border-none w-96"
    tabindex="-1" id="offcanvascliente" aria-labelledby="offcanvasExampleLabeledit">
    <div class="offcanvas-header flex items-center justify-between p-4">
        <h5 class="offcanvas-title mb-0 leading-normal font-semibold" id="offcanvasExampleLabeledit">Cadastro de Cliente
            avulso</h5>
        <button type="button"
            class="btn-close box-content w-4 h-4 p-2 -my-5 -mr-2 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
            data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow p-4 overflow-y-auto">

        <div class="dropdown relative mt-4">


            <div class="block p-6 rounded-lg shadow-lg bg-white max-w-md">
                <form method="POST" class="client-form" id="client-edit-form">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-group mb-6">
                            <input type="hidden" name="user_id" id="user_id_" value="0">

                            <input type="text"
                                class="form-control
                                block
                                w-full
                                px-3
                                py-1.5
                                text-base
                                font-normal
                                text-gray-700
                                bg-white bg-clip-padding
                                border border-solid border-gray-300
                                rounded
                                transition
                                ease-in-out
                                m-0
                                focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                                id="nome_" name="nome" aria-describedby="emailHelp123" placeholder="First name">
                        </div>

                    </div>
                    <div class="form-group mb-6">
                        <input type="email"
                            class="form-control block
                              w-full
                              px-3
                              py-1.5
                              text-base
                              font-normal
                              text-gray-700
                              bg-white bg-clip-padding
                              border border-solid border-gray-300
                              rounded
                              transition
                              ease-in-out
                              m-0
                              focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            id="exampleInput125" id="email_" name="email_" placeholder="Email address">
                    </div>
                    <div class="form-group mb-6">
                        <input type="telefone"
                            class="form-control block
                              w-full
                              px-3
                              py-1.5
                              text-base
                              font-normal
                              text-gray-700
                              bg-white bg-clip-padding
                              border border-solid border-gray-300
                              rounded
                              transition
                              ease-in-out
                              m-0
                              focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            id="exampleInput125" id="telefone_" name="telefone" placeholder="Telefone address">
                    </div>
                    <div class="datepicker relative form-floating form-group mb-6" data-mdb-toggle-button="false">
                        <input type="text"
                            class="form-control block w-full px-3 py-1.5 text-base font-normal text-gray-700 bg-white bg-clip-padding border border-solid border-gray-300 rounded transition ease-in-out m-0 focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            placeholder="Select a date" data-mdb-toggle="datepicker" name="client_inicio_" id="client_inicio_"/>
                        <label for="floatingInput" class="text-gray-700">Data de Inicio</label>
                    </div>
                    <div class="form-group mb-6">
                        <select
                            class="form-select appearance-none
                          block
                          w-full
                          px-3
                          py-1.5
                          text-base
                          font-normal
                          text-gray-700
                          bg-white bg-clip-padding bg-no-repeat
                          border border-solid border-gray-300
                          rounded
                          transition
                          ease-in-out
                          m-0
                          focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            aria-label="Default select example"
                            id="games_select_" name="games_select_">
                            <option selected>Selecione um BOT</option>
                            @foreach ( $games  as $game )
                            <option value="{{$game->id_game}}">{{$game->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group mb-6">
                        <select
                            class="ice-cream form-select appearance-none
                          block
                          w-full
                          px-3
                          py-1.5
                          text-base
                          font-normal
                          text-gray-700
                          bg-white bg-clip-padding bg-no-repeat
                          border border-solid border-gray-300
                          rounded
                          transition
                          ease-in-out
                          m-0
                          focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            aria-label="Default select example"
                            id="plans_select_" name="plans_select">
                            <option selected>Selecione um plano</option>
                            @foreach ( $plans as $plan )
                                <option value="{{$plan->id}}">{{$plan->description}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div id="divteste" class=" divteste form-group mb-6 hidden">
                        <input type="number"
                            class="form-control
                            block
                            w-full
                            px-3
                            py-1.5
                            text-base
                            font-normal
                            text-gray-700
                            bg-white bg-clip-padding
                            border border-solid border-gray-300
                            rounded
                            transition
                            ease-in-out
                            m-0
                            focus:text-gray-700 focus:bg-white focus:border-blue-600 focus:outline-none"
                            id="testedays_" name="testedays" aria-describedby="testedays" placeholder="teste">
                    </div>
                <input type="hidden" id="client_id_" name="client_id_" value="">

                    <div class="form-group form-check text-center mb-6">
                        <input type="checkbox"
                            class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain mr-2 cursor-pointer"
                            id="exampleCheck25" checked>
                        <label class="form-check-label inline-block text-gray-800" for="exampleCheck25">Ativo?</label>
                    </div>

                </form>
            </div>


            <!--Footer-->
            <div class="flex justify-end pt-2">
                <button
                    class="modal-close px-4 bg-transparent p-3 rounded-lg text-indigo-500 hover:bg-gray-100 hover:text-indigo-400 mr-2"
                    data-bs-dismiss="offcanvas">Cancelar</button>
                <button class="  px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400 modal-close"
                    data-bs-dismiss="offcanvas" onCLick="editClientJson()">Atualizar</button>
            </div>
        </div>
    </div>
</div
