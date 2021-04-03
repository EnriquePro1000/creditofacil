<li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseTwo" aria-expanded="true" aria-controls="collapseTwo">
          <i> </i>
          <span>Seguridad</span>
        </a>
        <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo" data-parent="#accordionSidebar">
          <div class="bg-white py-2 collapse-inner rounded">
            @if (auth()->id() === 1)
              
              <a class="collapse-item" href="RegistrarUsuario" onclick = "location = 'RegistrarUsuario'">Registrar usuario</a>
            @endif
              <a class="collapse-item" href="RegistrarCliente" onclick = "location = 'RegistrarCliente'">Registrar cliente</a> 
            <a class="collapse-item" href="ModificarCliente" onclick = "location = 'ModificarCliente'">Modificar cliente</a>
            <a class="collapse-item" href="ModificarSaldo" onclick = "location = 'ModificarSaldo'">Modificar saldo</a>
          </div>
        </div>
      </li>