import React, { useRef, useEffect, useState } from 'react';
import * as THREE from 'three';

function NativeShaderGradient({ isDark = false }) {
    const mountRef = useRef(null);
    const sceneRef = useRef(null);
    const rendererRef = useRef(null);
    const cameraRef = useRef(null);
    const meshRef = useRef(null);
    const animationRef = useRef(null);
    const [isLoaded, setIsLoaded] = useState(false);

    useEffect(() => {
        if (!mountRef.current) return;

        // Scene setup
        const scene = new THREE.Scene();
        sceneRef.current = scene;

        // Camera setup
        const camera = new THREE.PerspectiveCamera(45, window.innerWidth / window.innerHeight, 0.1, 1000);
        camera.position.set(-1.4, 0, 3.6);
        camera.lookAt(0, 0, 0);
        cameraRef.current = camera;

        // Renderer setup
        const renderer = new THREE.WebGLRenderer({ 
            antialias: true, 
            alpha: true,
            powerPreference: "high-performance"
        });
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(window.devicePixelRatio || 1);
        renderer.setClearColor(0x000000, 0);
        rendererRef.current = renderer;

        mountRef.current.appendChild(renderer.domElement);

        // Shader material
        const vertexShader = `
            varying vec2 vUv;
            varying vec3 vPosition;
            varying vec3 vNormal;
            
            void main() {
                vUv = uv;
                vPosition = position;
                vNormal = normal;
                gl_Position = projectionMatrix * modelViewMatrix * vec4(position, 1.0);
            }
        `;

        const fragmentShader = `
            uniform float uTime;
            uniform float uDensity;
            uniform float uFrequency;
            uniform float uSpeed;
            uniform float uStrength;
            uniform float uAmplitude;
            uniform vec3 color1;
            uniform vec3 color2;
            uniform vec3 color3;
            uniform float brightness;
            
            varying vec2 vUv;
            varying vec3 vPosition;
            varying vec3 vNormal;
            
            // Noise function
            float noise(vec2 st) {
                return fract(sin(dot(st.xy, vec2(12.9898, 78.233))) * 43758.5453123);
            }
            
            float fbm(vec2 st) {
                float value = 0.0;
                float amplitude = 0.5;
                float frequency = 0.0;
                
                for (int i = 0; i < 6; i++) {
                    value += amplitude * noise(st);
                    st *= 2.0;
                    amplitude *= 0.5;
                }
                return value;
            }
            
            void main() {
                vec2 st = vUv * uDensity;
                st += uTime * uSpeed;
                
                // Create water-like waves
                float wave1 = sin(st.x * uFrequency + uTime * uSpeed) * uStrength;
                float wave2 = sin(st.y * uFrequency * 1.3 + uTime * uSpeed * 0.7) * uStrength;
                float wave3 = sin((st.x + st.y) * uFrequency * 0.8 + uTime * uSpeed * 1.2) * uStrength;
                
                float combinedWave = (wave1 + wave2 + wave3) / 3.0;
                
                // Add noise for texture
                float noiseValue = fbm(st * 2.0 + uTime * 0.1);
                combinedWave += noiseValue * 0.3;
                
                // Create gradient based on position and waves
                vec3 gradient = mix(
                    mix(color1, color2, smoothstep(0.0, 1.0, vUv.x + combinedWave * 0.5)),
                    color3,
                    smoothstep(0.0, 1.0, vUv.y + combinedWave * 0.3)
                );
                
                // Add depth and lighting
                float depth = 1.0 - smoothstep(0.0, 1.0, length(vUv - 0.5) * 2.0);
                gradient *= depth;
                
                // Apply brightness
                gradient *= brightness;
                
                // Add some reflection
                float reflection = 0.1;
                gradient += reflection * (1.0 - depth);
                
                gl_FragColor = vec4(gradient, 1.0);
            }
        `;

        // Create geometry (water plane)
        const geometry = new THREE.PlaneGeometry(4, 4, 64, 64);
        
        // Create material
        const material = new THREE.ShaderMaterial({
            vertexShader,
            fragmentShader,
            uniforms: {
                uTime: { value: 0 },
                uDensity: { value: 1.3 },
                uFrequency: { value: 5.5 },
                uSpeed: { value: 0.1 },
                uStrength: { value: 4.0 },
                uAmplitude: { value: 0.0 },
                color1: { value: new THREE.Color(0xff4326) }, // Red-orange
                color2: { value: new THREE.Color(0xdbd9c9) }, // Light beige
                color3: { value: new THREE.Color(0xe1867a) }, // Pink
                brightness: { value: 1.4 }
            },
            transparent: true,
            side: THREE.DoubleSide
        });

        // Create mesh
        const mesh = new THREE.Mesh(geometry, material);
        mesh.rotation.x = 0;
        mesh.rotation.y = 10 * Math.PI / 180;
        mesh.rotation.z = 50 * Math.PI / 180;
        scene.add(mesh);
        meshRef.current = mesh;

        // Animation loop
        const animate = () => {
            animationRef.current = requestAnimationFrame(animate);
            
            if (material.uniforms.uTime) {
                material.uniforms.uTime.value += 0.016; // ~60fps
            }
            
            // Subtle rotation
            mesh.rotation.z += 0.001;
            
            renderer.render(scene, camera);
        };

        animate();
        setIsLoaded(true);

        // Handle resize
        const handleResize = () => {
            if (camera && renderer) {
                camera.aspect = window.innerWidth / window.innerHeight;
                camera.updateProjectionMatrix();
                renderer.setSize(window.innerWidth, window.innerHeight);
            }
        };

        window.addEventListener('resize', handleResize);

        // Cleanup
        return () => {
            if (animationRef.current) {
                cancelAnimationFrame(animationRef.current);
            }
            window.removeEventListener('resize', handleResize);
            if (mountRef.current && renderer.domElement) {
                mountRef.current.removeChild(renderer.domElement);
            }
            if (renderer) {
                renderer.dispose();
            }
            if (geometry) {
                geometry.dispose();
            }
            if (material) {
                material.dispose();
            }
        };
    }, [isDark]);

    return (
        <div className="absolute inset-0">
            <div 
                ref={mountRef} 
                className="absolute inset-0"
                style={{
                    zIndex: 1,
                    opacity: isLoaded ? 1 : 0,
                    transition: 'opacity 0.5s ease-in-out'
                }}
            />
            
            {/* Loading indicator */}
            {!isLoaded && (
                <div className="absolute inset-0 z-10 flex items-center justify-center">
                    <div className="w-8 h-8 border-2 border-[#ff4326] border-t-transparent rounded-full animate-spin"></div>
                </div>
            )}
            
            {/* Overlay for better text readability */}
            <div 
                className="absolute inset-0 z-10"
                style={{
                    background: isDark 
                        ? 'linear-gradient(135deg, rgba(0,0,0,0.3) 0%, rgba(0,0,0,0.1) 50%, rgba(0,0,0,0.3) 100%)'
                        : 'linear-gradient(135deg, rgba(255,255,255,0.3) 0%, rgba(255,255,255,0.1) 50%, rgba(255,255,255,0.3) 100%)'
                }}
            />
        </div>
    );
}

export default NativeShaderGradient;
