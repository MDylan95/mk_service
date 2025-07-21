@extends('back.dashboard')

@section('content')

<div class="container mt-5">
    <h2 class="mb-4 text-center">📩 Mes Messages</h2>

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if($contacts->count())
    <div class="table-responsive shadow-sm rounded">
        <table class="table table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Prénom</th>
                    <th>Téléphone</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th style="width: 140px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($contacts as $contact)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        {{ $contact->nom }}
                        @if($contact->created_at->diffInHours(now()) < 24)
                            <span class="badge bg-warning text-dark ms-1">Nouveau</span>
                            @endif
                    </td>
                    <td>{{ $contact->prenom }}</td>
                    <td>{{ $contact->telephone }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($contact->message, 40, '...') }}</td>
                    <td>{{ $contact->created_at->format('d M Y à H:i') }}</td>
                    <td>
                        <button class="btn btn-sm btn-primary mb-1 w-100 voir-btn"
                            data-nom="{{ $contact->nom }}"
                            data-prenom="{{ $contact->prenom }}"
                            data-telephone="{{ $contact->telephone }}"
                            data-message="{{ e($contact->message) }}"
                            data-date="{{ $contact->created_at->format('d/m/Y à H:i') }}">
                            👀 Voir
                        </button>

                        <button class="btn btn-sm btn-danger w-100 supprimer-btn" data-id="{{ $contact->id }}">
                            🗑 Supprimer
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="d-flex justify-content-center mt-4">
        {{ $contacts->links('pagination::bootstrap-5') }}
    </div>

    @else
    <div class="text-center text-muted mt-5">Aucun message reçu pour le moment.</div>
    @endif
</div>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    document.querySelectorAll('.voir-btn').forEach(button => {
        button.addEventListener('click', function() {
            const nom = this.dataset.nom;
            const prenom = this.dataset.prenom;
            const telephone = this.dataset.telephone;
            const message = this.dataset.message.replace(/\n/g, '<br>');
            const date = this.dataset.date;

            Swal.fire({
                title: `Message de ${nom} ${prenom}`,
                html: `
                    <p><strong>Téléphone :</strong> ${telephone}</p>
                    <p><strong>Message :</strong><br>${message}</p>
                    <p class="text-muted mt-2"><small>Reçu le ${date}</small></p>
                `,
                confirmButtonText: 'Fermer'
            });
        });
    });

    document.querySelectorAll('.supprimer-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();

            const id = this.dataset.id;
            const btn = this;
            btn.disabled = true;

            Swal.fire({
                title: 'Supprimer ce message ?',
                text: "Cette action est irréversible.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Oui, supprimer',
                cancelButtonText: 'Annuler'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch(`/administrateur/messages/${id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                'Accept': 'application/json'
                            }
                        })
                        .then(res => {
                            if (!res.ok) throw new Error('Erreur réseau');
                            return res.json();
                        })
                        .then(data => {
                            if (data.success) {
                                Swal.fire('Supprimé!', data.message, 'success');
                                btn.closest('tr').remove();
                            } else {
                                Swal.fire('Erreur', data.message || 'Une erreur est survenue.', 'error');
                                btn.disabled = false;
                            }
                        })
                        .catch(() => {
                            Swal.fire('Erreur', 'Une erreur est survenue.', 'error');
                            btn.disabled = false;
                        });
                } else {
                    btn.disabled = false;
                }
            });
        });
    });
</script>

@endsection