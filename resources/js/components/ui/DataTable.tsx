import { Table, Thead, Tbody, Tr, Th, Td, TableProps } from '@chakra-ui/react';
import { PropsWithChildren } from 'react';

export function DataTable({ children, ...props }: PropsWithChildren<TableProps>) {
  return (
    <Table variant="simple" bg="white" rounded="md" overflow="hidden" {...props}>
      {children}
    </Table>
  );
}
