import { NgModule } from '@angular/core';
import { CommonModule } from '@angular/common';



import { HoyPage } from './hoy.page';
import { FormsModule } from '@angular/forms';
import { IonicModule } from '@ionic/angular';
import { HoyPageRoutingModule } from './hoy-routing.module';

@NgModule({
  imports: [
    CommonModule,
    FormsModule,
    IonicModule,
    HoyPageRoutingModule
  ],
  declarations: [HoyPage]
})
export class HoyPageModule {}
