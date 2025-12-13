import { PropsWithChildren } from 'react';
import { Box, Container } from '@chakra-ui/react';
import { Navbar } from '../ui/Navbar';
import { Header } from '../landing/Header';

export function AppLayout({ children }: PropsWithChildren) {
  return (
    <Box minH="100vh" bg="gray.50" display="flex" justifyContent="center">
      <Box w="100%" maxW="480px">
        <Header />
        {children}
      </Box>
    </Box>
  );
}
