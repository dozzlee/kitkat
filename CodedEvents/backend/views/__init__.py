# from os.path import dirname, basename, isfile, join
# import glob

# modules = glob.glob(join(dirname(__file__), "*.py"))
# __all__ = [ basename(f)[:-3] for f in modules if isfile(f) and not f.endswith('__init__.py')]

from .user import UserViewSet as UserViewSet
from .roles import RolesViewSet as RolesViewSet
from .address import AddressViewSet as AddressViewSet
from .booking import BookingViewSet as BookingViewSet
from .category import CategoryViewSet as CategoryViewSet
from .event import EventViewSet as EventViewSet
from .ticket import TicketViewSet as TicketViewSet