import React, { useEffect, useMemo, useState } from 'react';

interface CountdownProps {
  targetDateISO: string; // ISO date string (yyyy-mm-dd)
  targetTime?: string; // optional time string (e.g., "14:30")
  title?: string;
}

type TimeLeft = {
  days: number;
  hours: number;
  minutes: number;
  seconds: number;
};

function calculateTimeLeft(targetDate: Date): TimeLeft | null {
  const now = new Date();
  const diffMs = targetDate.getTime() - now.getTime();
  if (diffMs <= 0) return null;

  const totalSeconds = Math.floor(diffMs / 1000);
  const days = Math.floor(totalSeconds / (24 * 3600));
  const hours = Math.floor((totalSeconds % (24 * 3600)) / 3600);
  const minutes = Math.floor((totalSeconds % 3600) / 60);
  const seconds = totalSeconds % 60;

  return { days, hours, minutes, seconds };
}

const Countdown: React.FC<CountdownProps> = ({ targetDateISO, targetTime, title }) => {
  const targetDate = useMemo(() => {
    // Combine date and optional time into a single Date in local time
    // Event fields in the app are strings; assume local timezone display
    const [year, month, day] = targetDateISO.split('-').map(Number);
    let hours = 0;
    let minutes = 0;
    if (targetTime) {
      const [h, m] = targetTime.split(':').map(Number);
      hours = Number.isFinite(h) ? h : 0;
      minutes = Number.isFinite(m) ? m : 0;
    }
    return new Date(year, (month ?? 1) - 1, day ?? 1, hours, minutes, 0, 0);
  }, [targetDateISO, targetTime]);

  const [timeLeft, setTimeLeft] = useState<TimeLeft | null>(() => calculateTimeLeft(targetDate));

  useEffect(() => {
    setTimeLeft(calculateTimeLeft(targetDate));
    const intervalId = setInterval(() => {
      setTimeLeft(calculateTimeLeft(targetDate));
    }, 1000);

    return () => clearInterval(intervalId);
  }, [targetDate]);

  if (!timeLeft) return null;

  return (
    <div className="bg-gray-900 text-white">
      <div className="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
        {title && (
          <h2 className="text-center text-2xl md:text-3xl font-bold mb-4">{title}</h2>
        )}
        <div className="flex items-center justify-center gap-4 md:gap-6">
          {[
            { label: 'Days', value: timeLeft.days },
            { label: 'Hours', value: timeLeft.hours },
            { label: 'Minutes', value: timeLeft.minutes },
            { label: 'Seconds', value: timeLeft.seconds },
          ].map((unit) => (
            <div key={unit.label} className="text-center">
              <div className="text-3xl md:text-5xl font-bold tabular-nums">{unit.value.toString().padStart(2, '0')}</div>
              <div className="text-sm md:text-base text-gray-300">{unit.label}</div>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
};

export default Countdown;



