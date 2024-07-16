import {Component, HostListener} from '@angular/core';
import {NavigationService} from '../../../services/navigation.service.js';
import {RouterLink} from '@angular/router';
import {OrderService} from '../../../services/order-service.service.js';

@Component({
  selector: 'app-navbar',
  standalone: true,
  imports: [RouterLink],
  templateUrl: './navbar.component.html',
  styleUrl: './navbar.component.css',
})
export class NavbarComponent {
  isDropdownOpen = false;
  orderMade = false;
  isSidebarOpen = false;

  constructor(public navigationService: NavigationService, private orderService: OrderService) {}

  onOrderButtonClick() {
    this.isDropdownOpen = false;
    this.isSidebarOpen = false;
    this.delayOrderButtonAvailability();
    this.orderService.makeOrder().subscribe((response) => {
      console.log(response);
    });
  }

  delayOrderButtonAvailability() {
    this.orderMade = true;
    setTimeout(() => {
      this.orderMade = false;
    }, 2000);
  }

  toggleSidebar() {
    this.isSidebarOpen = !this.isSidebarOpen;
    if (this.isSidebarOpen) {
      this.isDropdownOpen = false;
    }
  }

  toggleDropdown(event: MouseEvent) {
    this.isDropdownOpen = !this.isDropdownOpen;
    event.stopPropagation();
  }

  @HostListener('document:click', ['$event'])
  onDocumentClick(event: MouseEvent) {
    if (this.isDropdownOpen) {
      this.isDropdownOpen = false;
    }
  }
}
