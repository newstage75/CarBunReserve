
<!-- navbar section -->
<nav class="navbar navbar-expand-lg navbar-light bg-dark py-3">
        <div class="container">
          <a class="navbar-brand" href="#">
            <h2 class="text-white pt-1">CarBunBun社有車予約</h2>
          </a>
          <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
          <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav ms-auto">
              <li class="nav-item">
                <a class="nav-link" href="reservation">予約一覧</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="myreserve">My予約変更・削除</a>
              </li>
              <li class="nav-item">
                <a class="nav-link" href="#">ユーザー別履歴</a>
              </li>
              <button form="logout-button" class="btn btn-primary ms-2" type="submit">
                ログアウト
              </button>
              <form id="logout-button" method="POST" action="{{ route('logout') }}">
                @csrf
              </form>
            </ul>
          </div>
        </div>
      </nav>