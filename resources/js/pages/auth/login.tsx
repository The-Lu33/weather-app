import { LoginForm } from '@/components/auth/login-form';
import { Card, CardContent, CardDescription, CardFooter, CardHeader, CardTitle } from '@/components/ui/card';
import { CloudSun } from 'lucide-react';

type LoginForm = {
    email: string;
    password: string;
    remember: boolean;
};


export default function Login() {
  

    return (
        <div className="flex min-h-screen flex-col items-center justify-center bg-gradient-to-b from-sky-100 to-blue-50 p-4">
            <a href="/" className="text-primary absolute top-4 left-4 flex items-center gap-2 hover:underline md:top-8 md:left-8">
                <CloudSun className="h-5 w-5" />
                <span>Volver al inicio</span>
            </a>

            <Card className="w-full max-w-md">
                <CardHeader className="space-y-1 text-center">
                    <div className="flex justify-center">
                        <CloudSun className="text-primary h-10 w-10" />
                    </div>
                    <CardTitle className="text-2xl">Bienvenido de nuevo</CardTitle>
                    <CardDescription>Inicia sesión en tu cuenta para acceder a tu información del clima</CardDescription>
                </CardHeader>
                <CardContent>
                    <LoginForm />
                </CardContent>
                <CardFooter className="flex flex-col space-y-4">
                    <div className="text-muted-foreground text-center text-sm">
                        ¿No tienes una cuenta?{' '}
                        <a href="/auth/register" className="text-primary hover:text-primary/80 underline">
                            Regístrate
                        </a>
                    </div>
                    <div className="text-muted-foreground text-center text-xs">
                        Al iniciar sesión, aceptas nuestros{' '}
                        <a href="#" className="hover:text-muted-foreground/80 underline">
                            Términos de servicio
                        </a>{' '}
                        y{' '}
                        <a href="#" className="hover:text-muted-foreground/80 underline">
                            Política de privacidad
                        </a>
                    </div>
                </CardFooter>
            </Card>
        </div>
    );
}
