import { Component, OnInit } from '@angular/core';
import { AuthService } from '../auth.service';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
  styleUrls: ['./login.component.css']
})
export class LoginComponent implements OnInit {

  invalidLogin: boolean; 
  constructor(private Auth: AuthService,
              private router: Router
              ) { }

   signIn(credentials){
    this.Auth.logIn(credentials).subscribe(res => { //send data to server
      console.log(res)
      if(res){      
        this.router.navigate(['/admin'])
      //  this.Auth.setLoggedIn(true)
        
    } else { 
     this.invalidLogin = true;
      }
    })
  }
  
  ngOnInit() {
  }

}
