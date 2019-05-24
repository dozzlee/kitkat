from backend.models import Address
from backend.serializers import AddressSerializer
from rest_framework import viewsets


class AddressViewSet(viewsets.ModelViewSet):
    """
    retrieve:
        Return a address instance.

    list:
        Return all address, ordered by most recently joined.

    create:
        Create a new address.

    delete:
        Remove an existing address.

    partial_update:
        Update one or more fields on an existing address.

    update:
        Update a address.
    """
    queryset = Address.objects.all()
    serializer_class = AddressSerializer