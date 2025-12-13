import { useState, useCallback } from 'react';

export type AuthUser = {
  id: number;
  name: string;
  email: string;
};

export function useAuth() {
  const [user, setUser] = useState<AuthUser | null>(null);
  const [loading, setLoading] = useState(false);

  const login = useCallback(async (email: string, password: string) => {
    setLoading(true);
    try {
      // TODO: Integrate with backend via Inertia/Laravel route
      // Placeholder: simulate login
      await new Promise((r) => setTimeout(r, 500));
      setUser({ id: 1, name: 'Client Sample', email });
      return true;
    } finally {
      setLoading(false);
    }
  }, []);

  const register = useCallback(async (name: string, email: string, password: string) => {
    setLoading(true);
    try {
      await new Promise((r) => setTimeout(r, 500));
      setUser({ id: 2, name, email });
      return true;
    } finally {
      setLoading(false);
    }
  }, []);

  const logout = useCallback(async () => {
    setLoading(true);
    try {
      await new Promise((r) => setTimeout(r, 300));
      setUser(null);
    } finally {
      setLoading(false);
    }
  }, []);

  return { user, loading, login, register, logout };
}
