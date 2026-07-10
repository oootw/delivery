import ArrowLeft from "@/assets/icons/arrow-left.svg";
import ArrowRight from "@/assets/icons/arrow-right.svg";
import BillLine from "@/assets/icons/bill-line.svg";
import Card from "@/assets/icons/card.svg";
import ChevronDown from "@/assets/icons/chevron-down.svg";
import ChevronLeft from "@/assets/icons/chevron-left.svg";
import ChevronRight from "@/assets/icons/chevron-right.svg";
import ChevronUp from "@/assets/icons/chevron-up.svg";
import Crest from "@/assets/icons/crest.svg";
import Exit from "@/assets/icons/exit.svg";
import List from "@/assets/icons/list.svg";
import Lunch from "@/assets/icons/lunch.svg";
import Mark from "@/assets/icons/mark.svg";
import Message from "@/assets/icons/message.svg";
import Minus from "@/assets/icons/minus.svg";
import Notification from "@/assets/icons/notification.svg";
import Phone from "@/assets/icons/phone.svg";
import Plus from "@/assets/icons/plus.svg";
import Question from "@/assets/icons/question.svg";
import Retry from "@/assets/icons/retry.svg";
import Search from "@/assets/icons/search.svg";
import Share from "@/assets/icons/share.svg";
import Trash from "@/assets/icons/trash.svg";

export const icons = {
  "arrow-left": ArrowLeft,
  "arrow-right": ArrowRight,
  "bill-line": BillLine,
  card: Card,
  "chevron-down": ChevronDown,
  "chevron-left": ChevronLeft,
  "chevron-right": ChevronRight,
  "chevron-up": ChevronUp,
  crest: Crest,
  exit: Exit,
  list: List,
  lunch: Lunch,
  mark: Mark,
  message: Message,
  minus: Minus,
  notification: Notification,
  phone: Phone,
  plus: Plus,
  question: Question,
  retry: Retry,
  search: Search,
  share: Share,
  trash: Trash,
} as const;

export type IconName = keyof typeof icons;
