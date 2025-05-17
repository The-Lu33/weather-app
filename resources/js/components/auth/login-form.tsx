'use client';

import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { LockIcon, MailIcon } from 'lucide-react';
import { useState } from 'react';
import { toast } from 'sonner';

export function LoginForm() {
    const [formData, setFormData] = useState({
        email: '',
        password: '',
    });
    const [loading, setLoading] = useState(false);
    const [error, setError] = useState<string | null>(null);

    const handleChange = (e: React.ChangeEvent<HTMLInputElement>) => {
        setFormData({ ...formData, [e.target.name]: e.target.value });
    };

    const submit = async (e: React.FormEvent) => {
        e.preventDefault();
        setLoading(true);
        setError(null);
        try {
            const response = await fetch('/api/auth/login', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    Accept: 'application/json',
                },
                body: JSON.stringify(formData),
            });
            const data = await response.json();
            if (response.ok && data.access_token) {
                localStorage.setItem('access_token', data.toaccess_tokenken);
            } else {
                toast(data.message || 'Error al iniciar sesión', { description: 'error de inicio de sesion' });
            }
        } catch (err) {
            console.log(err);
            toast('Error de red');
        } finally {
            setLoading(false);
        }
    };

    return (
        <form onSubmit={submit} className="space-y-4 pt-4">
            <div className="space-y-2">
                <Label htmlFor="email">Correo Electrónico</Label>
                <div className="relative">
                    <div className="text-muted-foreground absolute inset-y-0 left-0 flex items-center pl-3">
                        <MailIcon className="h-5 w-5" />
                    </div>
                    <Input
                        id="email"
                        name="email"
                        type="email"
                        placeholder="tu@email.com"
                        className="pl-10"
                        value={formData.email}
                        onChange={handleChange}
                        required
                    />
                </div>
            </div>

            <div className="space-y-2">
                <Label htmlFor="password">Contraseña</Label>
                <div className="relative">
                    <div className="text-muted-foreground absolute inset-y-0 left-0 flex items-center pl-3">
                        <LockIcon className="h-5 w-5" />
                    </div>
                    <Input
                        id="password"
                        name="password"
                        type="password"
                        placeholder="••••••••"
                        className="pl-10"
                        value={formData.password}
                        onChange={handleChange}
                        required
                    />
                </div>
            </div>

            {error && <div className="text-sm text-red-500">{error}</div>}

            <Button type="submit" className="w-full" disabled={loading}>
                {loading ? (
                    <>
                        <div className="border-background mr-2 h-4 w-4 animate-spin rounded-full border-2 border-t-transparent"></div>
                        Iniciando sesión...
                    </>
                ) : (
                    'Iniciar Sesión'
                )}
            </Button>
        </form>
    );
}
