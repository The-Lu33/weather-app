import { Button } from "@/components/ui/button"
import { Card } from "@/components/ui/card"
import { ArrowRight, FileText, CloudSun, Github } from "lucide-react"

export default function LandingPage() {
  return (
    <div className="relative min-h-screen overflow-hidden bg-gradient-to-b from-sky-400 to-blue-600">
      {/* Elementos decorativos */}
      <div className="absolute left-0 top-0 h-96 w-96 rounded-full bg-white/10 blur-3xl"></div>
      <div className="absolute bottom-0 right-0 h-96 w-96 rounded-full bg-blue-300/20 blur-3xl"></div>

      {/* Nubes animadas */}
      <div className="absolute left-1/4 top-20 h-20 w-40 animate-pulse rounded-full bg-white/30 blur-xl"></div>
      <div
        className="absolute right-1/3 top-40 h-16 w-32 animate-pulse rounded-full bg-white/20 blur-xl"
        style={{ animationDelay: "1s" }}
      ></div>
      <div
        className="absolute bottom-40 left-1/3 h-24 w-48 animate-pulse rounded-full bg-white/20 blur-xl"
        style={{ animationDelay: "2s" }}
      ></div>

      <div className="container relative z-10 mx-auto flex min-h-screen flex-col items-center justify-center px-4 py-16 text-white">
        <header className="absolute left-0 right-0 top-0 flex items-center justify-between p-6">
          <div className="flex items-center gap-2 text-2xl font-bold">
            <CloudSun className="h-8 w-8" />
            <span>WeatherApp</span>
          </div>
          <div className="flex items-center gap-4">
            <a href="/api/documentation">
              <Button variant="ghost" className="text-white hover:bg-white/20">
                Documentación Swagger
              </Button>
            </a>
            <a href="/docs-ui">
              <Button variant="ghost" className="text-white hover:bg-white/20">
                Documentación UI
              </Button>
            </a>
            <a href="https://github.com/The-Lu33/weather-app" target="_blank">
              <Button variant="ghost" className="text-white hover:bg-white/20">
                <Github className="mr-2 h-5 w-5" />
                GitHub
              </Button>
            </a>
          </div>
        </header>

        <main className="flex flex-1 flex-col items-center justify-center">
          <div className="mb-8 text-center">
            <h1 className="mb-4 text-5xl font-bold leading-tight md:text-6xl lg:text-7xl">
              Tu portal meteorológico <br className="hidden md:block" />
              <span className="bg-gradient-to-r from-white to-blue-200 bg-clip-text text-transparent">personal</span>
            </h1>
            <p className="mx-auto max-w-2xl text-lg text-blue-100 md:text-xl">
              Consulta el clima en tiempo real, guarda tus ubicaciones favoritas y accede a tu historial de búsquedas
              con una interfaz que se adapta a las condiciones climáticas.
            </p>
          </div>

          <div className=" w-full max-w-xl gap-8">
            {/* <Card className="flex flex-col items-center justify-center bg-white/10 p-8 backdrop-blur-sm">
              <CloudSun className="mb-4 h-16 w-16 text-yellow-300" />
              <h2 className="mb-2 text-2xl font-bold">Prueba la Demo</h2>
              <p className="mb-6 text-center text-blue-100">
                Experimenta todas las funcionalidades de nuestra aplicación de clima con datos en tiempo real.
              </p>
              <a href="/auth/login" className="w-full">
                <Button className="w-full bg-white text-blue-600 hover:bg-blue-50">
                  Iniciar Demo
                  <ArrowRight className="ml-2 h-4 w-4" />
                </Button>
              </a>
            </Card> */}

            <Card className="flex flex-col items-center justify-center bg-white/10 p-8 backdrop-blur-sm">
              <FileText className="mb-4 h-16 w-16 text-blue-200" />
              <h2 className="mb-2 text-2xl font-bold">Documentación API</h2>
              <p className="mb-6 text-center text-blue-100">
                Explora nuestra documentación completa para integrar nuestros servicios en tus aplicaciones.
              </p>
              <a href="/docs-ui" className="w-full">
                <Button variant="outline" className="w-full border-white text-blue-600 hover:bg-blue-50">
                  Ver Documentación
                  <ArrowRight className="ml-2 h-4 w-4" />
                </Button>
              </a>
            </Card>
          </div>

          <div className="mt-16 grid gap-8 md:grid-cols-3">
            <div className="flex flex-col items-center text-center">
              <div className="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-white/20">
                <CloudSun className="h-8 w-8" />
              </div>
              <h3 className="mb-2 text-xl font-bold">Clima en Tiempo Real</h3>
              <p className="text-blue-100">Consulta temperatura, viento, humedad y más para cualquier ubicación.</p>
            </div>

            <div className="flex flex-col items-center text-center">
              <div className="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-white/20">
                <svg
                  className="h-8 w-8"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"
                  />
                </svg>
              </div>
              <h3 className="mb-2 text-xl font-bold">Ciudades Favoritas</h3>
              <p className="text-blue-100">
                Guarda tus ubicaciones favoritas para acceder rápidamente a su información.
              </p>
            </div>

            <div className="flex flex-col items-center text-center">
              <div className="mb-4 flex h-16 w-16 items-center justify-center rounded-full bg-white/20">
                <svg
                  className="h-8 w-8"
                  fill="none"
                  stroke="currentColor"
                  viewBox="0 0 24 24"
                  xmlns="http://www.w3.org/2000/svg"
                >
                  <path
                    strokeLinecap="round"
                    strokeLinejoin="round"
                    strokeWidth={2}
                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"
                  />
                </svg>
              </div>
              <h3 className="mb-2 text-xl font-bold">Historial de Búsquedas</h3>
              <p className="text-blue-100">
                Accede a tu historial de consultas para un seguimiento continuo del clima.
              </p>
            </div>
          </div>
        </main>

        <footer className="mt-16 text-center text-sm text-blue-100">
          <p className="mt-1">Desarrollado con ❤️ para mi prueba técnica </p>
        </footer>
      </div>
    </div>
  )
}
