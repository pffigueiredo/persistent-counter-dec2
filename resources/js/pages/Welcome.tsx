import React from 'react';
import { Head } from '@inertiajs/react';
import { Button } from '@/components/ui/button';
import { router } from '@inertiajs/react';

interface Props {
    count: number;
    [key: string]: unknown;
}

export default function Welcome({ count }: Props) {
    const handleIncrement = () => {
        router.post(route('counter.store'), { action: 'increment' }, {
            preserveState: true,
            preserveScroll: true
        });
    };

    const handleDecrement = () => {
        router.post(route('counter.store'), { action: 'decrement' }, {
            preserveState: true,
            preserveScroll: true
        });
    };

    return (
        <>
            <Head title="Counter App" />
            <div className="min-h-screen bg-gradient-to-br from-gray-900 via-blue-900 to-purple-900 flex items-center justify-center">
                <div className="bg-white/10 backdrop-blur-sm rounded-2xl p-12 shadow-2xl border border-white/20">
                    <div className="text-center">
                        <h1 className="text-4xl font-bold text-white mb-8">
                            Counter App
                        </h1>
                        
                        <div className="bg-white/20 rounded-xl p-8 mb-8">
                            <div className="text-6xl font-bold text-white mb-2">
                                {count}
                            </div>
                            <div className="text-white/70 text-lg">
                                Current Count
                            </div>
                        </div>
                        
                        <div className="flex gap-4 justify-center">
                            <Button 
                                onClick={handleDecrement}
                                variant="outline"
                                size="lg"
                                className="bg-red-500/20 border-red-400 text-white hover:bg-red-500/30 hover:border-red-300 min-w-[120px]"
                            >
                                Decrease
                            </Button>
                            <Button 
                                onClick={handleIncrement}
                                size="lg"
                                className="bg-green-500/20 border-green-400 text-white hover:bg-green-500/30 hover:border-green-300 min-w-[120px]"
                            >
                                Increase
                            </Button>
                        </div>
                        
                        <p className="text-white/60 text-sm mt-6">
                            Your counter value is automatically saved to the database
                        </p>
                    </div>
                </div>
            </div>
        </>
    );
}