from backend.models import Ticket
from backend.serializers import TicketSerializer
from rest_framework import viewsets


class TicketViewSet(viewsets.ModelViewSet):
    """
    retrieve:
        Return a ticket instance.

    list:
        Return all ticket, ordered by most recently joined.

    create:
        Create a new ticket.

    delete:
        Remove an existing ticket.

    partial_update:
        Update one or more fields on an existing ticket.

    update:
        Update a ticket.
    """
    queryset = Ticket.objects.all()
    serializer_class = TicketSerializer