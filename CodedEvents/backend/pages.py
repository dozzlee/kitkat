from django.shortcuts import render,get_object_or_404, render_to_response, redirect

# Create your views here.
from .models import Event, Role, Address, Category, Profile, Ticket, Booking
from backend.forms import *
from django.http import HttpResponseRedirect,HttpResponse,JsonResponse
from django.urls import reverse
import datetime
from django.contrib.auth.decorators import permission_required
from backend.serializers import EventSerializer
from django.forms import formset_factory
import json as simplejson
import numbers

def get_user_cart(request):
        user = Profile.objects.filter(id=request.user.id).get()

        # Check if user has cart else create new cart
        if Cart.objects.filter(user=user).exists():
                # user_cart = Cart.objects.filter(id=user.id).get()
                user_cart = Cart.objects.prefetch_related('cartinstance_set').get(user=user)
        else:
                user_cart = Cart(user=user, created_at=datetime.date.today(), updated_at=datetime.date.today())
                user_cart.save()
        
        return user_cart

def index(request):
        num_visits = request.session.get('num_visits', 0)
        request.session['num_visits'] = num_visits+1
        user_cart = get_user_cart(request)
        event_list = Event.objects.all()

        return render(request,'index.html',context={'event_list': event_list, 'num_visits': num_visits, 'cart':user_cart},)

def AdminEventList(request):
        event_list = Event.objects.prefetch_related('ticket_set').all()
        user_cart = get_user_cart(request)

        # If this is a POST request then process the Form data
        if request.method == 'POST':
                # Create a form instance and populate it with data from the request (binding):
                event_instance = get_object_or_404(Event, pk=request.POST.get('event_id', None))
                
                # Check if edit or delete for event post submit
                if request.POST.get('event_submit_type', None) == "event_delete":
                        form = EditEventForm()
                        event_instance.delete()
                elif request.POST.get('event_submit_type', None) == "event_edit":
                        form = EditEventForm(request.POST, instance=event_instance)

                        # Check if the form is valid:
                        if form.is_valid():
                                event_instance.save()
                                event_list = Event.objects.all()
                        else:
                                response = simplejson.dumps({"status": "Error", "request": request.POST})
                                return HttpResponse (response)
                elif request.POST.get('event_submit_type', None) == "event_alloc_ticket":
                        form = EditEventForm(request.POST, instance=event_instance)
                        form.save()
                elif request.POST.get('event_submit_type', None) == "event_ticket_update":
                        form = EditEventForm(request.POST, instance=event_instance)
                        ticket_instance = get_object_or_404(Ticket, pk=request.POST.get('ticket_id', None))
                        form.save(ticket=ticket_instance)
                        # form.add_error('quantity', 'Ticket qty value allocated is greater than event tickets available')
                elif request.POST.get('event_submit_type', None) == "event_ticket_delete":
                        form = EditEventForm()
                        ticket_instance = get_object_or_404(Ticket, pk=request.POST.get('ticket_id', None))
                        ticket_instance.delete()
                else:
                        response = simplejson.dumps({"status": "Error", "request": request.POST})
                        return HttpResponse (response)
        # If this is a GET (or any other method) create the default form
        else:
                form = EditEventForm()

        # Render the HTML template with the data in the context variable.
        return render(request, 'admin/event_list.html', context={'event_list': event_list, 'form': form, 'cart':user_cart},)

def AdminEventAdd(request):
        event_list = Event.objects.all()
        user_cart = get_user_cart(request)

        # If this is a POST request then process the Form data
        if request.method == 'POST':
                # Create a form instance and populate it with data from the request (binding):
                form = AddEventForm(request.POST)

                # Check if the form is valid:
                if form.is_valid():
                        event_instance = form.save()
        # If this is a GET (or any other method) create the default form
        else:
                form = AddEventForm()

        # Render the HTML template with the data in the context variable.
        return render(request, 'admin/event_add.html',context={'event_list': event_list, 'form': form, 'cart':user_cart},)

def AdminOrdersList(request):
        event_list = Event.objects.all()
        user_cart = get_user_cart(request)

        # If this is a POST request then process the Form data
        if request.method == 'POST':
                # Create a form instance and populate it with data from the request (binding):
                event_instance = get_object_or_404(Event, pk=request.POST.get('event_id', None))
                form = EditEventForm(request.POST, instance=event_instance)

                # Check if the form is valid:
                if form.is_valid():
                        event_instance.save()
                        event_list = Event.objects.all()
        # If this is a GET (or any other method) create the default form
        else:
                # proposed_renewal_date = datetime.date.today() + datetime.timedelta(weeks=3)
                # form = EditEventForm(initial={'end_time': proposed_renewal_date})
                form = EditEventForm()

        # Render the HTML template with the data in the context variable.
        return render(request, 'admin/event_booking.html',context={'event_list': event_list, 'form': form, 'cart':user_cart},)

def EventView(request, id):
        event_list = Event.objects.prefetch_related('ticket_set').get(pk=id)
        tickets = []
        today_time = datetime.date.today()
        user_cart = get_user_cart(request)

        if request.method == 'POST':
                user = request.user
                formset = BuyTicketForm(request.POST)

                # Create cart instances
                for key, ticket in enumerate(event_list.ticket_set.all()):

                        # Check if value checked
                        if "ticket_{}".format(key) in request.POST:
                                tickets.append(key)
                                cart_instance = CartInstance(cart=user_cart, ticket=ticket, quantity=request.POST["quantity_{}".format(key)],created_at=datetime.date.today(), updated_at=datetime.date.today())
                                cart_instance.save()
                        
                user_cart = get_user_cart(request)
                # return render(request,'cart/cart_view.html',context={'cart':user_cart},)]
                return redirect('cart_view')
        else:
                formset = BuyTicketForm()
                
        return render(request,'events/event_view.html',context={'event': event_list, 'form': formset, 'cart': user_cart},)

def CartView(request):
        user_cart = get_user_cart(request)

         # If this is a POST request then process the Form data
        if request.method == 'POST':
                cart_instance = get_object_or_404(CartInstance, pk=request.POST.get('cart_item_id', None))
                
                # Check if edit or delete for cart post submit type
                if request.POST.get('cart_submit_type', None) == "cart_update":

                        if request.POST['cart_item_quantity'].isdigit():
                                if int(request.POST['cart_item_quantity']) == int(0):
                                        cart_instance.delete()
                                else:
                                        cart_instance.quantity = request.POST['cart_item_quantity']
                                        cart_instance.save()
                        else:
                                response = simplejson.dumps({"status": "Error", "request": request.POST, "type": int(request.POST['cart_item_quantity'])})
                                return HttpResponse (response)
                        user_cart = get_user_cart(request)
                elif request.POST.get('cart_submit_type', None) == "cart_delete":
                        cart_instance.delete()
                        user_cart = get_user_cart(request)
                else:
                        response = simplejson.dumps({"status": "Error", "request": request.POST})
                        return HttpResponse (response)

        return render(request,'cart/cart_view.html',context={'cart':user_cart},)
