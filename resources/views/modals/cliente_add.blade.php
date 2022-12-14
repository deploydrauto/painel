<div class="offcanvas offcanvas-start fixed bottom-0 flex flex-col max-w-full bg-white invisible bg-clip-padding shadow-sm outline-none transition duration-300 ease-in-out text-gray-700 top-0 left-0 border-none w-96"
    tabindex="-1" id="offcanvasExample" aria-labelledby="offcanvasExampleLabel">
    <div class="offcanvas-header flex items-center justify-between p-4">
        <h5 class="offcanvas-title mb-0 leading-normal font-semibold" id="offcanvasExampleLabel">Cadastro de Cliente avulso</h5>
        <button type="button"
            class="btn-close box-content w-4 h-4 p-2 -my-5 -mr-2 text-black border-none rounded-none opacity-50 focus:shadow-none focus:outline-none focus:opacity-100 hover:text-black hover:opacity-75 hover:no-underline"
            data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body flex-grow p-4 overflow-y-auto">

        <div class="dropdown relative mt-4">
            <form method="POST" class="client-form" id="client-form">
                @csrf

                <div class="flex flex-wrap">
                    <input type="hidden" name="user_id" id="user_id" value="0">
                    {{-- <x-bladewind.input name="nome" id="client_nome" required="true" label="nome" /> --}}
                    {{-- <x-bladewind.input name="email" id="client_email" required="true" label="email" /> --}}
                </div>
                {{-- <x-bladewind.input name="telefone" id="client_telefone" required="true" label="telefone" /> --}}
                {{-- <x-bladewind.datepicker name="client_inicio" id="client_inicio" required="true" label="inicio" /> --}}

                {{-- <x-bladewind.dropdown name="games_select" id="games_select" placeholder="Selecione um BOT" --}}
                data="{{ json_encode($games) }}" />
            {{-- <x-bladewind.dropdown name="plans_select" id="plans_select" placeholder="Selecione um plano" --}}
                {{-- data="{{ json_encode($plans) }}" /> --}}

                <p>
                    {{-- <x-bladewind.checkbox checked="true" label="Ativo?" /> --}}
                </p>

                <br>
                <br>

            </form>
            <!--Footer-->
            <div class="flex justify-end pt-2">
                <button
                    class="modal-close px-4 bg-transparent p-3 rounded-lg text-indigo-500 hover:bg-gray-100 hover:text-indigo-400 mr-2"  data-bs-dismiss="offcanvas">Cancelar</button>
                <button class="  px-4 bg-indigo-500 p-3 rounded-lg text-white hover:bg-indigo-400 modal-close"
                data-bs-dismiss="offcanvas"   onCLick="storeClientJson()"  >Cadastrar</button>
            </div>
        </div>
    </div>
</div>
