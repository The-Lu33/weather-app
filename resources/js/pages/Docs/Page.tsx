import { Badge } from '@/components/ui/badge';
import { Button } from '@/components/ui/button';
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import { Tabs, TabsContent, TabsList, TabsTrigger } from '@/components/ui/tabs';
import { ArrowLeft, CloudSun } from 'lucide-react';

export default function DocsPage() {
    return (
        <div className="min-h-screen bg-slate-50">
            <header className="sticky top-0 z-10 bg-white">
                <div className="container mx-auto flex h-16 items-center justify-between">
                    <div className="flex items-center gap-2">
                        <CloudSun className="h-6 w-6 text-black" />
                        <span className="text-xl font-bold text-black">WeatherApp API</span>
                    </div>
                    <div className="flex items-center gap-4">
                        <a href="/">
                            <Button variant="ghost" size="sm">
                                <ArrowLeft className="mr-2 h-4 w-4" />
                                Volver al inicio
                            </Button>
                        </a>
                        {/* <a href="/auth/login">
                            <Button size="sm">Probar Demo</Button>
                        </a> */}
                    </div>
                </div>
            </header>

            <main className="container mx-auto py-8">
                <div className="mx-auto max-w-4xl space-y-8">
                    <div className="space-y-2">
                        <h1 className="text-3xl font-bold tracking-tight">Documentación de la API</h1>
                        <p className="text-muted-foreground text-lg">Guía completa para desarrolladores sobre cómo utilizar nuestra API de clima</p>
                    </div>

                    <div className="grid gap-6 md:grid-cols-3">
                        <Card>
                            <CardHeader className="pb-3">
                                <CardTitle>Autenticación</CardTitle>
                                <CardDescription>Gestión de usuarios y tokens</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <ul className="space-y-2 text-sm">
                                    <li className="flex items-center gap-2">
                                        <Badge variant="outline" className="bg-blue-50 text-blue-700">
                                            POST
                                        </Badge>
                                        <span>/api/auth/register</span>
                                    </li>
                                    <li className="flex items-center gap-2">
                                        <Badge variant="outline" className="bg-blue-50 text-blue-700">
                                            POST
                                        </Badge>
                                        <span>/api/auth/login</span>
                                    </li>
                                    <li className="flex items-center gap-2">
                                        <Badge variant="outline" className="bg-blue-50 text-blue-700">
                                            POST
                                        </Badge>
                                        <span>/api/auth/logout</span>
                                    </li>
                                </ul>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader className="pb-3">
                                <CardTitle>Clima</CardTitle>
                                <CardDescription>Consulta de datos meteorológicos</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <ul className="space-y-2 text-sm">
                                    <li className="flex items-center gap-2">
                                        <Badge variant="outline" className="bg-green-50 text-green-700">
                                            GET
                                        </Badge>
                                        <span>/api/weather/current</span>
                                    </li>
                                    <li className="flex items-center gap-2">
                                        <Badge variant="outline" className="bg-blue-50 text-blue-700">
                                            POST
                                        </Badge>
                                        <span>/api/weather/favorite</span>
                                    </li>
                                    <li className="flex items-center gap-2">
                                        <Badge variant="outline" className="bg-green-50 text-green-700">
                                            GET
                                        </Badge>
                                        <span>/api/weather/favorites</span>
                                    </li>
                                    <li className="flex items-center gap-2">
                                        <Badge variant="outline" className="bg-green-50 text-green-700">
                                            GET
                                        </Badge>
                                        <span>/api/weather/history</span>
                                    </li>
                                </ul>
                            </CardContent>
                        </Card>

                        <Card>
                            <CardHeader className="pb-3">
                                <CardTitle>Usuario</CardTitle>
                                <CardDescription>Información del perfil</CardDescription>
                            </CardHeader>
                            <CardContent>
                                <ul className="space-y-2 text-sm">
                                    <li className="flex items-center gap-2">
                                        <Badge variant="outline" className="bg-green-50 text-green-700">
                                            GET
                                        </Badge>
                                        <span>/api/user</span>
                                    </li>
                                </ul>
                            </CardContent>
                        </Card>
                    </div>

                    <Tabs defaultValue="auth" className="w-full">
                        <TabsList className="grid w-full grid-cols-3">
                            <TabsTrigger value="auth">Autenticación</TabsTrigger>
                            <TabsTrigger value="weather">Clima</TabsTrigger>
                            <TabsTrigger value="user">Usuario</TabsTrigger>
                        </TabsList>

                        <TabsContent value="auth" className="space-y-4">
                            <h3 className="text-lg font-semibold">Endpoints de Autenticación</h3>

                            <EndpointCard
                                method="POST"
                                endpoint="/api/auth/register"
                                description="Registra un nuevo usuario en el sistema"
                                requestBody={{
                                    name: 'string',
                                    email: 'string',
                                    password: 'string',
                                    password_confirmation: 'string',
                                }}
                                responseExample={{
                                    user: {
                                        id: 1,
                                        name: 'Usuario Ejemplo',
                                        email: 'usuario@ejemplo.com',
                                        created_at: '2023-05-17T12:00:00.000000Z',
                                    },
                                    access_token: '1|laravel_sanctum_token_example',
                                    token_type: 'Bearer',
                                }}
                            />

                            <EndpointCard
                                method="POST"
                                endpoint="/api/auth/login"
                                description="Inicia sesión con credenciales existentes"
                                requestBody={{
                                    email: 'string',
                                    password: 'string',
                                }}
                                responseExample={{
                                    user: {
                                        id: 1,
                                        name: 'Usuario Ejemplo',
                                        email: 'usuario@ejemplo.com',
                                        created_at: '2023-05-17T12:00:00.000000Z',
                                    },
                                    access_token: '1|laravel_sanctum_token_example',
                                    token_type: 'Bearer',
                                }}
                            />

                            <EndpointCard
                                method="POST"
                                endpoint="/api/auth/logout"
                                description="Cierra la sesión actual y revoca el token"
                                authRequired={true}
                                responseExample={{
                                    message: 'Tokens revocados',
                                }}
                            />
                        </TabsContent>

                        <TabsContent value="weather" className="space-y-4">
                            <h3 className="text-lg font-semibold">Endpoints de Clima</h3>

                            <EndpointCard
                                method="GET"
                                endpoint="/api/weather/current"
                                description="Obtiene el clima actual para una ubicación específica"
                                authRequired={true}
                                queryParams={{
                                    city: 'string (nombre de ciudad)',
                                    lang: 'string (opcional, idioma de respuesta)',
                                }}
                                responseExample={{
                                    temperature: 22.5,
                                    condition: 'Soleado',
                                    wind_kph: 10.5,
                                    humidity: 60,
                                    local_time: '2025-05-17 12:00',
                                }}
                            />

                            <EndpointCard
                                method="POST"
                                endpoint="/api/weather/favorite"
                                description="Añade una ubicación a favoritos"
                                authRequired={true}
                                requestBody={{
                                    city: 'string (nombre de ciudad)',
                                }}
                                responseExample={{
                                    id: 1,
                                    user_id: 2,
                                    city: 'Madrid',
                                    created_at: '2025-05-17T12:00:00Z',
                                    updated_at: '2025-05-17T12:00:00Z',
                                }}
                            />

                            <EndpointCard
                                method="GET"
                                endpoint="/api/weather/favorites"
                                description="Obtiene todas las ubicaciones favoritas del usuario"
                                authRequired={true}
                                responseExample={[
                                    {
                                        id: 1,
                                        user_id: 2,
                                        city: 'Madrid',
                                        created_at: '2025-05-17T12:00:00Z',
                                        updated_at: '2025-05-17T12:00:00Z',
                                    },
                                ]}
                            />

                            <EndpointCard
                                method="GET"
                                endpoint="/api/weather/history"
                                description="Obtiene el historial de búsquedas del usuario"
                                authRequired={true}
                                responseExample={{
                                    history: [
                                        {
                                            id: 1,
                                            user_id: 1,
                                            query: 'Madrid',
                                            created_at: '2025-05-17T12:00:00Z',
                                            updated_at: '2025-05-17T12:00:00Z',
                                        },
                                        {
                                            id: 2,
                                            user_id: 1,
                                            city: 'Barcelona',
                                            created_at: '2025-05-17T12:00:00Z',
                                            updated_at: '2025-05-17T12:00:00Z',
                                        },
                                    ],
                                }}
                            />
                        </TabsContent>

                        <TabsContent value="user" className="space-y-4">
                            <h3 className="text-lg font-semibold">Endpoints de Usuario</h3>

                            <EndpointCard
                                method="GET"
                                endpoint="/api/user"
                                description="Obtiene la información del usuario autenticado"
                                authRequired={true}
                                responseExample={{
                                    id: 1,
                                    name: 'Juan Pérez',
                                    email: 'juan@email.com',
                                    created_at: '2025-05-17T12:00:00Z',
                                    updated_at: '2025-05-17T12:00:00Z',
                                }}
                            />
                        </TabsContent>
                    </Tabs>

                    <div className="rounded-lg border p-6">
                        <h2 className="mb-4 text-xl font-semibold">Autenticación con Laravel Sanctum</h2>
                        <p className="text-muted-foreground mb-4">
                            Nuestra API utiliza Laravel Sanctum para la autenticación. Todos los endpoints protegidos requieren un token de acceso
                            válido.
                        </p>

                        <h3 className="mb-2 text-lg font-medium">Cómo autenticarse</h3>
                        <ol className="text-muted-foreground mb-4 space-y-2 pl-5">
                            <li>1. Registra un nuevo usuario o inicia sesión para obtener un token</li>
                            <li>2. Incluye el token en el encabezado de todas las solicitudes protegidas</li>
                            <li>
                                3. Formato: <code className="bg-muted rounded px-1 py-0.5 text-sm">Authorization: Bearer {'{token}'}</code>
                            </li>
                        </ol>

                        <div className="bg-muted rounded-md p-4">
                            <pre className="text-sm">
                                {`// Ejemplo de solicitud autenticada
fetch('https://example.com/api/weather?city=Madrid', {
  method: 'GET',
  headers: {
    'Content-Type': 'application/json',
    'Authorization': 'Bearer 1|laravel_sanctum_token_example'
  }
})`}
                            </pre>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    );
}

function EndpointCard({
    method,
    endpoint,
    description,
    authRequired = false,
    requestBody = null,
    queryParams = null,
    responseExample,
}: {
    method: 'GET' | 'POST' | 'PUT' | 'DELETE';
    endpoint: string;
    description: string;
    authRequired?: boolean;
    requestBody?: Record<string, string> | null;
    queryParams?: Record<string, string> | null;
    responseExample: any;
}) {
    // Determinar color del método
    const getMethodColor = (method: string) => {
        switch (method) {
            case 'GET':
                return 'bg-green-100 text-green-800';
            case 'POST':
                return 'bg-blue-100 text-blue-800';
            case 'PUT':
                return 'bg-yellow-100 text-yellow-800';
            case 'DELETE':
                return 'bg-red-100 text-red-800';
            default:
                return 'bg-gray-100 text-gray-800';
        }
    };

    return (
        <div className="rounded-lg border">
            <div className="flex items-center justify-between border-b p-4">
                <div className="flex items-center gap-3">
                    <span className={`inline-block rounded-md px-2.5 py-1 text-xs font-medium ${getMethodColor(method)}`}>{method}</span>
                    <code className="bg-muted rounded px-2 py-1 text-sm">{endpoint}</code>
                </div>
                {authRequired && (
                    <Badge variant="outline" className="text-amber-600">
                        Requiere Autenticación
                    </Badge>
                )}
            </div>

            <div className="p-4">
                <p className="text-muted-foreground text-sm">{description}</p>

                {(requestBody || queryParams) && (
                    <div className="mt-4 space-y-3">
                        {queryParams && (
                            <div>
                                <h4 className="mb-1 text-sm font-medium">Parámetros de Consulta</h4>
                                <pre className="bg-muted rounded-md p-2 text-xs">{JSON.stringify(queryParams, null, 2)}</pre>
                            </div>
                        )}

                        {requestBody && (
                            <div>
                                <h4 className="mb-1 text-sm font-medium">Cuerpo de la Petición</h4>
                                <pre className="bg-muted rounded-md p-2 text-xs">{JSON.stringify(requestBody, null, 2)}</pre>
                            </div>
                        )}
                    </div>
                )}

                <div className="mt-4">
                    <h4 className="mb-1 text-sm font-medium">Respuesta de Ejemplo</h4>
                    <pre className="bg-muted max-h-40 overflow-auto rounded-md p-2 text-xs">{JSON.stringify(responseExample, null, 2)}</pre>
                </div>
            </div>
        </div>
    );
}
