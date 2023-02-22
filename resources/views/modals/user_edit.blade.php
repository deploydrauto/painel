<div class="modal m-auto  max-w-md fade fixed top-5 inset-0 hidden w-full  outline-none overflow-x-hidden overflow-y-auto"
    id="user_edit_modal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
    aria-labelledby="staticBackdropLabel" aria-hidden="true">
    <div class="modal-dialog relative w-auto pointer-events-none">
        <div
            class="modal-content border-none shadow-lg relative flex flex-col w-full pointer-events-auto bg-white bg-clip-padding rounded-md outline-none text-current">
            <div
                class="modal-header flex flex-shrink-0 items-center justify-between p-4 border-b border-gray-200 rounded-t-md">
                <h5 class="text-xl font-medium leading-normal text-gray-800" id="exampleModalLabel">
                    Edição de Usuario
                </h5>
                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="modal" aria-label="Close">x</button>
            </div>

            <div class="block p-6 rounded-lg shadow-lg bg-white max-w-md">
                <form method="POST" action="{{ route('user.edit') }}" id="user-edit-form">
                    @csrf
                    <div class="grid grid-cols-2 gap-4">
                        <div class="form-group mb-6">
                            <input type="hidden" name="edit_user_id" id="edit_user_id" value="0">

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
                                id="edit_name" name="edit_name" aria-describedby="emailHelp123" placeholder="Nome">
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
                             id="edit_email" name="edit_email" placeholder="Email address">
                    </div>
                    <div class="form-group mb-6">
                        <input type="password"
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
                            id="edit_password" name="edit_password" placeholder="Password" required>
                    </div>
                    <div class="form-group mb-6">
                        <input type="password"
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
                            id="edit_password_confirmation" name="edit_password_confirmation" required placeholder="Password">
                    </div>
                    <div class="form-group form-check text-center mb-6">
                        <input type="checkbox"
                            class="form-check-input appearance-none h-4 w-4 border border-gray-300 rounded-sm bg-white checked:bg-blue-600 checked:border-blue-600 focus:outline-none transition duration-200 mt-1 align-top bg-no-repeat bg-center bg-contain mr-2 cursor-pointer"
                            id="user_edit_ativo" checked>
                        <label class="form-check-label inline-block text-gray-800" for="user_edit_ativo">Ativo?</label>
                    </div>
                    <button type="submit"
                        class="
                            w-full
                            px-6
                            py-2.5
                            bg-blue-600
                            text-white
                            font-medium
                            text-xs
                            leading-tight
                            uppercase
                            rounded
                            shadow-md
                            hover:bg-blue-700 hover:shadow-lg
                            focus:bg-blue-700 focus:shadow-lg focus:outline-none focus:ring-0
                            active:bg-blue-800 active:shadow-lg
                            transition
                            duration-150
                            ease-in-out">Atualizar</button>
                </form>
            </div>

        </div>
    </div>
</div>
</div>
