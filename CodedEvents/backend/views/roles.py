from backend.models import Role
from backend.serializers import RoleSerializer
from rest_framework import viewsets


class RolesViewSet(viewsets.ModelViewSet):
    """
    retrieve:
        Return a role instance.

    list:
        Return all role, ordered by most recently joined.

    create:
        Create a new role.

    delete:
        Remove an existing role.

    partial_update:
        Update one or more fields on an existing role.

    update:
        Update a role.
    """
    queryset = Role.objects.all()
    serializer_class = RoleSerializer